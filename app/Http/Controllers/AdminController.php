<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\UtilityHelpers;

class AdminController extends Controller
{
    use UtilityHelpers;

    public function dashboard()
    {
        if (Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                return view('home.dashboard');
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return redirect()->route('home.login');
        }
    }

    public function news()
    {
        if (Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                try {
                    $news = $this->getNews();

                    return view('home.news', [
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
                $username = Auth::user()->username;
                $headline = trim($request->input('headline'));
                $content = trim($request->input('content'));

                $newsID = $this->insertRecord('news', [
                    'headline' => $headline,
                    'content' => $content,
                    'username' => $username
                ]);

                if($newsID) {
                    $this->setFlash('Success', 'News has been added.');

                    return redirect()->route('home.news');
                } else {
                    $this->setFlash('Failed', 'Oops! Failed to add news.');

                    return redirect()->route('home.news');
                }

                break;
            default:
                break;
        }
    }
}
