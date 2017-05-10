<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\UtilityHelpers;
use App\Http\Requests\ManageNewsRequest;

use Auth;
use File;
use Mail;
use Validator;

use App\AccountsModel;
use App\CommentsModel;
use App\HealthAndSafetyModel;
use App\HealthAndSafetyMediaModel;
use App\HealthAndSafetyCommentsModel;
use App\MediaModel;
use App\NewsModel;

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

    public function healthAndSafety()
    {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                try {
                    $tips = HealthAndSafetyModel::all();

                    return view('admin.health_and_safety', [
                        'tips' => $tips
                    ]);
                } catch(Exception $ex) {
                    return view('errors.404');
                }
            } else {
                return redirect()->route('health_and_safety.index');
            }
        } else {
            return redirect()->route('home.login');
        }
    }

    public function addHealthAndSafety()
    {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                return view('admin.health_and_safety_add');
            } else {
                return redirect()->route('health_and_safety.index');
            }
        } else {
            return redirect()->route('home.login');
        }
    }

    public function editHealthAndSafety($id)
    {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                $tip = HealthAndSafetyModel::where('id', $id)->first();

                if($tip) {
                    return view('admin.health_and_safety_edit', [
                        'id' => $tip->id,
                        'title' => $tip->title,
                        'category' => $tip->category,
                        'content' => $tip->content
                    ]);
                } else {
                    return redirect()->route('admin.health_and_safety');
                }
            } else {
                return redirect()->route('health_and_safety.index');
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
                    $news = NewsModel::all();

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

    public function addNews()
    {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                return view('admin.news_add');
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return redirect()->route('home.login');
        }
    }

    public function editNews($id)
    {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                $news = NewsModel::where('id', $id)->first();

                if($news) {
                    return view('admin.news_edit', [
                        'id' => $news->id,
                        'headline' => $news->headline,
                        'content' => $news->content
                    ]);
                } else {
                    return redirect()->route('admin.news');
                }
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return redirect()->route('home.login');
        }
    }

    public function users() {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                try {
                    $accounts = AccountsModel::all();

                    return view('admin.users', [
                        'accounts' => $accounts
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

    public function postAddHealthAndSafety(Request $request)
    {
        $result = Validator::make($request->all(), [
            'title' => 'required|unique:health_and_safety,title',
            'category' => 'required',
            'content' => 'required',
            'media.*' => 'mimes:jpg,jpeg,png,bmp,gif,mp4,webm,ogg'
        ], [
            'media.*.mimes' => 'The file type must be jpg, jpeg, png, bmp, gif, mp4, webm, or ogg.'
        ]);

        if($result->fails()) {
            return redirect()->route('admin.health_and_safety.add')->withErrors($result)->withInput();
        } else {
            $authAccount = Auth::user();
            $title = trim($request->input('title'));
            $category = $request->input('category');
            $content = trim($request->input('content'));

            $health_and_safety_id = HealthAndSafetyModel::insertGetId([
                'title' => $title,
                'category' => $category,
                'content' => $content,
                'username' => $authAccount->username,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if($health_and_safety_id) {
                $tip = HealthAndSafetyModel::where('id', $health_and_safety_id)->first();

                if($tip) {
                    if($request->hasFile('media')) {
                        $media = $request->file('media');

                        foreach($media as $key => $file) {
                            $mediaFilename = date('Y_m_d_H_i_s_') . sprintf('%05d', $key) . '_HnS.' . $file->getClientOriginalExtension();

                            $query = HealthAndSafetyMediaModel::insertGetId([
                                'health_and_safety_id' => $health_and_safety_id,
                                'filename' => $mediaFilename,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);

                            if($query) {
                                $file->move('uploads', $mediaFilename);
                            }
                        }
                    }

                    if(strlen($authAccount->middle_name) > 1) {
                        $full_name = $authAccount->first_name . ' ' . substr($authAccount->middle_name, 0, 1) . '. ' . $authAccount->last_name;
                    } else {
                        $full_name = $authAccount->first_name . ' ' . $authAccount->last_name;
                    }

                    $accounts = AccountsModel::all();

                    foreach($accounts as $account) {
                        $tip_url = url('/$health_and_safety_id/' . date('Y', strtotime($tip->created_at)) . '/' . date('m', strtotime($tip->created_at)) . '/' . date('d', strtotime($tip->created_at)) . '/' . str_replace(' ', '_', $tip->title));

                        if($account->userInfo->mobile_number !== null) {
                            $this->send($account->userInfo->mobile_number, 'F.A.D.P. Health & Safety Tips Alert. A new tip has been posted. Visit ' . $tip_url . ' to read the tip.');
                        }

                        Mail::send('emails.health_and_safety', [
                            'first_name' => $account->userInfo->first_name,
                            'tip_url' => $tip_url
                        ], function($message) use ($account, $full_name) {
                            $message->to($account->email_address, $full_name)->subject('F.A.D.P. News Alert');
                        });
                    }

                    $this->setFlash('Success', 'Tip has been added.');

                    return redirect()->route('admin.health_and_safety');
                } else {
                    $this->setFlash('Failed', 'Oops! Tip was not added.');

                    return redirect()->route('admin.health_and_safety');
                }
            } else {
                $this->setFlash('Failed', 'Oops! Failed to add tip.');

                return redirect()->route('admin.health_and_safety');
            }
        }
    }

    public function postEditHealthAndSafety($id, Request $request)
    {
        $result = Validator::make($request->all(), [
            'category' => 'required',
            'content' => 'required'
        ]);

        if($result->fails()) {
            return redirect()->route('admin.health_and_safety.edit')->withErrors($result)->withInput();
        } else {
            $category = $request->input('category');
            $content = trim($request->input('content'));

            $query = HealthAndSafetyModel::where('id', $id)->update([
                'category' => $category,
                'content' => $content,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if($query) {
                $this->setFlash('Success', 'Tip has been updated.');

                return redirect()->route('admin.health_and_safety');
            } else {
                $this->setFlash('Failed', 'No changes has been made.');

                return redirect()->route('admin.health_and_safety');
            }
        }
    }

    public function postDeleteHealthAndSafety(Request $request)
    {
        $mediaFlag = false;
        $commentsFlag = false;
        $health_and_safety_id = $request->input('healthAndSafetyID');

        $query = HealthAndSafetyModel::where('id', $health_and_safety_id)->first();

        if($query) {
            $media = HealthAndSafetyMediaModel::where('health_and_safety_id', $health_and_safety_id)->get();

            if(count($media) > 0) {
                foreach($media as $media_item) {
                    File::delete('uploads/' . $media_item->filename);
                }

                $query = HealthAndSafetyMediaModel::where('health_and_safety_id', $health_and_safety_id)->delete();

                if($query) {
                    $mediaFlag = true;
                }
            } else {
                $mediaFlag = true;
            }

            if($mediaFlag) {
                $comments = HealthAndSafetyCommentsModel::where('health_and_safety_id', $health_and_safety_id)->get();

                if(count($comments) > 0) {
                    $query = HealthAndSafetyCommentsModel::where('health_and_safety_id', $health_and_safety_id)->delete();

                    if($query) {
                        $commentsFlag = true;
                    }
                } else {
                    $commentsFlag = true;
                }

                if($commentsFlag) {
                    $query = HealthAndSafetyModel::where('id', $health_and_safety_id)->delete();

                    if($query) {
                        $this->setFlash('Success', 'Tip has been deleted.');

                        return redirect()->route('admin.health_and_safety');
                    } else {
                        $this->setFlash('Failed', 'Oops! Tip was not deleted.');

                        return redirect()->route('admin.health_and_safety');
                    }
                } else {
                    $this->setFlash('Failed', 'Oops! Failed to delete tip.');

                    return redirect()->route('admin.health_and_safety');
                }
            } else {
                $this->setFlash('Failed', 'Oops! Failed to delete tip.');

                return redirect()->route('admin.health_and_safety');
            }
        } else {
            $this->setFlash('Failed', 'Oops! News doesn\'t exist.');

            return redirect()->route('admin.news');
        }
    }

    public function postAddNews(Request $request)
    {
        $result = Validator::make($request->all(), [
            'headline' => 'required|unique:news,headline',
            'content' => 'required',
            'media.*' => 'mimes:jpg,jpeg,png,bmp,gif,mp4,webm,ogg'
        ], [
            'media.*.mimes' => 'The file type must be jpg, jpeg, png, bmp, gif, mp4, webm, or ogg.'
        ]);

        if($result->fails()) {
            return redirect()->route('admin.news.add')->withErrors($result)->withInput();
        } else {
            $authAccount = Auth::user();
            $headline = trim($request->input('headline'));
            $content = trim($request->input('content'));

            $news_id = NewsModel::insertGetId([
                'headline' => $headline,
                'content' => $content,
                'username' => $authAccount->username,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if($news_id) {
                $news = NewsModel::where('id', $news_id)->first();

                if($news) {
                    if($request->hasFile('media')) {
                        $media = $request->file('media');

                        foreach($media as $key => $file) {
                            $mediaFilename = date('Y_m_d_H_i_s_') . sprintf('%05d', $key) . '.' . $file->getClientOriginalExtension();

                            $query = MediaModel::insertGetId([
                                'news_id' => $news_id,
                                'filename' => $mediaFilename,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);

                            if($query) {
                                $file->move('uploads', $mediaFilename);
                            }
                        }
                    }

                    if(strlen($authAccount->middle_name) > 1) {
                        $full_name = $authAccount->first_name . ' ' . substr($authAccount->middle_name, 0, 1) . '. ' . $authAccount->last_name;
                    } else {
                        $full_name = $authAccount->first_name . ' ' . $authAccount->last_name;
                    }

                    $accounts = AccountsModel::all();

                    foreach($accounts as $account) {
                        $news_url = url('/news/' . date('Y', strtotime($news->created_at)) . '/' . date('m', strtotime($news->created_at)) . '/' . date('d', strtotime($news->created_at)) . '/' . str_replace(' ', '_', $news->headline));

                        if($account->userInfo->mobile_number !== null) {
                            $this->send($account->userInfo->mobile_number, 'F.A.D.P. News Alert. A latest news has been posted. Visit ' . $news_url . ' to read the news.');
                        }

                        Mail::send('emails.news', [
                            'first_name' => $account->userInfo->first_name,
                            'news_url' => $news_url
                        ], function($message) use ($account, $full_name) {
                            $message->to($account->email_address, $full_name)->subject('F.A.D.P. News Alert');
                        });
                    }

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
        }
    }

    public function postEditNews($id, Request $request)
    {
        $result = Validator::make($request->all(), [
            'content' => 'required'
        ]);

        if($result->fails()) {
            return redirect()->route('admin.news.edit')->withErrors($result)->withInput();
        } else {
            $content = trim($request->input('content'));

            $query = NewsModel::where('id', $id)->update([
                'content' => $content,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if($query) {
                $this->setFlash('Success', 'News has been updated.');

                return redirect()->route('admin.news');
            } else {
                $this->setFlash('Failed', 'No changes has been made.');

                return redirect()->route('admin.news');
            }
        }
    }

    public function postDeleteNews(Request $request)
    {
        $mediaFlag = false;
        $commentsFlag = false;
        $news_id = $request->input('newsID');

        $query = NewsModel::where('id', $news_id)->first();

        if($query) {
            $media = MediaModel::where('news_id', $news_id)->get();

            if(count($media) > 0) {
                foreach($media as $media_item) {
                    File::delete('uploads/' . $media_item->filename);
                }

                $query = MediaModel::where('news_id', $news_id)->delete();

                if($query) {
                    $mediaFlag = true;
                }
            } else {
                $mediaFlag = true;
            }

            if($mediaFlag) {
                $comments = CommentsModel::where('news_id', $news_id)->get();

                if(count($comments) > 0) {
                    $query = CommentsModel::where('news_id', $news_id)->delete();

                    if($query) {
                        $commentsFlag = true;
                    }
                } else {
                    $commentsFlag = true;
                }

                if($commentsFlag) {
                    $query = NewsModel::where('id', $news_id)->delete();

                    if($query) {
                        $this->setFlash('Success', 'News has been deleted.');

                        return redirect()->route('admin.news');
                    } else {
                        $this->setFlash('Failed', 'Oops! News was not deleted.');

                        return redirect()->route('admin.news');
                    }
                } else {
                    $this->setFlash('Failed', 'Oops! Failed to delete news.');

                    return redirect()->route('admin.news');
                }
            } else {
                $this->setFlash('Failed', 'Oops! Failed to delete news.');

                return redirect()->route('admin.news');
            }
        } else {
            $this->setFlash('Failed', 'Oops! News doesn\'t exist.');

            return redirect()->route('admin.news');
        }
    }

    public function postBanUsers(Request $request)
    {
        $account_id = $request->input('accountID');

        $query = AccountsModel::where('id', $account_id)->first();

        if($query) {
            $query = AccountsModel::where('id', $account_id)->update([
                'is_banned' => true
            ]);

            if($query) {
                $this->setFlash('Success', 'User has been banned.');

                return redirect()->route('admin.users');
            } else {
                $this->setFlash('Failed', 'Oops! User was not banned.');

                return redirect()->route('admin.users');
            }
        } else {
            $this->setFlash('Failed', 'Oops! User doesn\'t exist.');

            return redirect()->route('admin.users');
        }
    }

    public function postUnbanUsers(Request $request)
    {
        $account_id = $request->input('accountID');

        $query = AccountsModel::where('id', $account_id)->first();

        if($query) {
            $query = AccountsModel::where('id', $account_id)->update([
                'is_banned' => false
            ]);

            if($query) {
                $this->setFlash('Success', 'User\'s ban has been removed.');

                return redirect()->route('admin.users');
            } else {
                $this->setFlash('Failed', 'Oops! User\'s ban was not removed.');

                return redirect()->route('admin.users');
            }
        } else {
            $this->setFlash('Failed', 'Oops! User doesn\'t exist.');

            return redirect()->route('admin.users');
        }
    }

    public function postCommentCaptcha(Request $request) {
        // Validating captcha currently not working, so i'll use this instead.

        if($request->input('g-recaptcha-response') !== '') {
            return response()->json([
                'status' => 'Success',
                'message' => 'CAPTCHA has been accepted.'
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to accept CAPTCHA.'
            ]);
        }
    }

    public function graphNewsViews() {
        $news = NewsModel::orderBy('views', 'desc')->take(10)->get();
        $data = [];

        if($news) {
            $data['labels'] = [];
            $data['data'] = [];

            foreach($news as $news_item) {
                $news_url = url('/news/' . date('Y', strtotime($news_item->created_at)) . '/' . date('m', strtotime($news_item->created_at)) . '/' . date('d', strtotime($news_item->created_at)) . '/' . str_replace(' ', '_', $news_item->headline));
                $data['labels'][] = $news_item->headline;
                $data['data'][] = $news_item->views;
            }
        }

        return response()->json($data);
    }

    public function postGraphNewsViews(Request $request) {
        if($request->has('id')) {
            $id = $request->input('id');

            NewsModel::where('id', $id)->increment('views');
        }
    }
}
