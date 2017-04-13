<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\UtilityHelpers;

use Auth;

class AdminController extends Controller
{
    use UtilityHelpers;

    public function dashboard()
    {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                return view('admin.dashboard');
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return redirect()->route('home.login');
        }
    }

    public function news()
    {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                try {
                    $news = $this->getNews();

                    return view('admin.news', [
                        'news' => $news
                    ]);
                } catch(Exception $ex) {
                    return view('errors.404');
                }
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return redirect()->route('home.login');
        }
    }

    public function postNews(Request $request)
    {
        $action = $request->input('action');

        switch($action) {
            case 'Add':
                $account = Auth::user();
                $headline = trim($request->input('headline'));
                $content = trim($request->input('content'));

                $news_id = $this->insertRecord('news', [
                    'headline' => $headline,
                    'content' => $content,
                    'username' => $account->username
                ]);

                if($news_id) {
                    $news = NewsModel::where('id', $news_id)->first();

                    if($news) {
                        Mail::send('emails.news', [
                            'first_name' => $account->userInfo->first_name,
                            'year' => date('Y', strtotime($news->created_at)),
                            'month' => date('m', strtotime($news->created_at)),
                            'day' => date('d', strtotime($news->created_at)),
                            'headline' => str_replace(' ', '_', $news->headline);
                        ], function($message) use ($account, $full_name) {
                            $message->to($account->email_address, $full_name)->subject('F.A.D.P. News Alert');
                        });

                        $this->setFlash('Success', 'News has been added.');

                        return redirect()->route('admin.news');
                    } else {
                        $this->setFlash('Failed', 'Oops! News was not added.');

                        return redirect()->route('admin.news');
                    }
                } else {
                    $this->setFlash('Failed', 'Oops! Failed to add news.');

                    return redirect()->route('admin.news');
                }

                break;
            default:
                break;
        }
    }
}
