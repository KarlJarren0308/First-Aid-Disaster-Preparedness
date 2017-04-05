<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\UtilityHelpers;
use App\NewsModel;
use App\CommentsModel;
use Snipe\BanBuilder\CensorWords;

class NewsController extends Controller
{
    use UtilityHelpers;

    public function index(Request $request)
    {
        $search = $request->input('search') ? trim($request->input('search')) : '';

        if($search != '') {
            $news = NewsModel::where('headline', 'like', '%' . $search . '%')->simplePaginate(10);
        } else {
            $news = NewsModel::simplePaginate(10);
        }

        return view('news.index', [
            'news' => $news
        ]);
    }

    public function show($id)
    {
        try {
            $news = $this->getNews($id);

            return view('news.show', [
                'news' => $news
            ]);
        } catch(Exception $ex) {
            return view('errors.404');
        }
    }

    public function comments(Request $request) {
        $newsID = $request->input('newsID') ? $request->input('newsID') : '';

        if($newsID !== '') {
            $comments = CommentsModel::where('news_id', $newsID)->orderBy('created_at', 'desc')->with('newsInfo')->with('accountInfo')->get();

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
        if (Auth::check()) {
            $censor = new CensorWords();
            $username = Auth::user()->username;
            $newsID = $request->input('newsID');
            $comment = $request->input('comment') ? $censor->censorString(trim($request->input('comment')))['clean'] : '';

            $commentID = $this->insertRecord('comments', [
                'comment' => $comment,
                'news_id' => $newsID,
                'username' => $username
            ]);

            if($commentID) {
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
}
