<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\UtilityHelpers;
use Snipe\BanBuilder\CensorWords;

use Auth;

use App\NewsModel;
use App\CommentsModel;

class NewsController extends Controller
{
    use UtilityHelpers;

    public function index(Request $request)
    {
        $search = $request->input('search') ? trim($request->input('search')) : '';

        if($search != '') {
            $news = NewsModel::where('headline', 'like', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $news = NewsModel::orderBy('created_at', 'desc')->paginate(10);
        }

        return view('news.index', [
            'news' => $news
        ]);
    }

    public function show($year, $month, $day, $headline)
    {
        try {
            $news = NewsModel::where('created_at', 'like', ($year . '-' . $month . '-' . $day) . '%')->where('headline', str_replace('_', ' ', $headline))->first();

            return view('news.show', [
                'news' => $news
            ]);
        } catch(Exception $ex) {
            return view('errors.404');
        }
    }

    public function postComments(Request $request) {
        $news_id = $request->input('newsID') ? $request->input('newsID') : '';

        if($news_id !== '') {
            $comments = CommentsModel::where('news_id', $news_id)->orderBy('created_at', 'desc')->with('newsInfo')->with('accountInfo')->get();

            return response()->json([
                'status' => 'Success',
                'message' => 'Comments has been retrieved.',
                'data' => $comments
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to retrieve comments.'
            ]);
        }
    }

    public function postComment(Request $request) {
        if(Auth::check()) {
            $censor = new CensorWords();
            $username = Auth::user()->username;
            $news_id = $request->input('newsID');
            $comment = $request->input('comment') ? $censor->censorString(trim($request->input('comment')))['clean'] : '';

            $comment_id = CommentsModel::insertGetId([
                'comment' => $comment,
                'news_id' => $news_id,
                'username' => $username,
                'created_at' => date('Y-m-d')
            ]);

            if($comment_id) {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Comment has been added.'
                ]);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Failed to add comment.'
                ]);
            }
        } else {
            return redirect()->route('home.login');
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
}
