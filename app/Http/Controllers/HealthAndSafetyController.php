<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\UtilityHelpers;
use Snipe\BanBuilder\CensorWords;

use Auth;

use App\HealthAndSafetyModel;
use App\HealthAndSafetyCommentsModel;

class HealthAndSafetyController extends Controller
{
    use UtilityHelpers;

    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        if($search != '') {
            $tips = HealthAndSafetyModel::where('title', 'like', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $tips = HealthAndSafetyModel::orderBy('created_at', 'desc')->paginate(10);
        }

        return view('health_and_safety.index', [
            'tips' => $tips
        ]);
    }

    public function show($year, $month, $day, $title)
    {
        try {
            $tip = HealthAndSafetyModel::where('created_at', 'like', ($year . '-' . $month . '-' . $day) . '%')->where('title', str_replace('_', ' ', $title))->first();

            return view('health_and_safety.show', [
                'tip' => $tip
            ]);
        } catch(Exception $ex) {
            return view('errors.404');
        }
    }

    public function postComments(Request $request) {
        $health_and_safety_id = $request->input('healthAndSafetyID', '');

        if($health_and_safety_id !== '') {
            $comments = HealthAndSafetyCommentsModel::where('health_and_safety_id', $health_and_safety_id)->orderBy('created_at', 'desc')->with('healthAndSafetyInfo')->with('accountInfo')->get();

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
            $health_and_safety_id = $request->input('healthAndSafetyID');
            $comment = $censor->censorString(trim($request->input('comment', '')))['clean'];

            $comment_id = HealthAndSafetyCommentsModel::insertGetId([
                'comment' => $comment,
                'health_and_safety_id' => $health_and_safety_id,
                'username' => $username,
                'created_at' => date('Y-m-d H:i:s')
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
}
