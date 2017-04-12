<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\UtilityHelpers;
use App\Http\Requests\RegisterRequest;

class HomeController extends Controller
{
    use UtilityHelpers;

    public function index()
    {
        return view('home.index');
    }

    public function donate()
    {
        return view('home.donate');
    }

    public function help()
    {
        return view('home.help');
    }

    public function about()
    {
        return view('home.about');
    }

    public function register()
    {
        if (Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                return redirect()->route('home.dashboard');
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return view('home.register');
        }
    }

    public function postRegister(RegisterRequest $request)
    {
        $accountID = $this->insertRecord('accounts', [
            'username' => $request->input('username'),
            'email_address' => $request->input('emailAddress'),
            'password' => bcrypt($request->input('password'))
        ]);

        if($accountID) {
            $userID = $this->insertRecord('users', [
                'id' => $accountID,
                'first_name' => $request->input('firstName'),
                'middle_name' => $request->input('middleName'),
                'last_name' => $request->input('lastName'),
                'gender' => $request->input('gender'),
                'birth_date' => $request->input('birthDate')
            ]);

            if($userID) {
                $this->setFlash('Success', 'Registration Successful.');

                return redirect()->route('home.login');
            } else {
                $this->setFlash('Failed', 'Oops! Registration Failed.');

                return redirect()->route('home.register');
            }
        } else {
            $this->setFlash('Failed', 'Oops! Registration Failed.');

            return redirect()->route('home.register');
        }
    }

    public function login()
    {
        if (Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                return redirect()->route('home.dashboard');
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return view('home.login');
        }
    }

    public function postLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $credentials = [
            'username' => $username,
            'password' => $password
        ];

        if(Auth::attempt($credentials)) {
            return redirect()->route('home.dashboard');
        } else {
            $this->setFlash('Failed', 'Invalid username and/or password.');

            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home.index');
    }

    public function passwordReset()
    {
        return view('home.password_reset');
    }

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
