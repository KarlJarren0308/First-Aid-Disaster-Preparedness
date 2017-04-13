<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\UtilityHelpers;
use App\Http\Requests\RegisterRequest;

use App\AccountsModel;

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
        $username = $request->input('username');
        $email_address = $request->input('emailAddress');
        $first_name = $request->input('firstName');
        $middle_name = $request->input('middleName');
        $last_name = $request->input('lastName');
        $verification_code = $this->generateVerificationCode($username);

        $accountID = $this->insertRecord('accounts', [
            'username' => $username,
            'email_address' => $email_address,
            'password' => bcrypt($request->input('password')),
            'verification_code' => $verification_code
        ]);

        if($accountID) {
            $userID = $this->insertRecord('users', [
                'id' => $accountID,
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'gender' => $request->input('gender'),
                'birth_date' => $request->input('birthDate')
            ]);

            if($userID) {
                if(strlen($middle_name) > 1) {
                    $full_name = $first_name . ' ' . substr($middle_name, 0, 1) . '. ' . $last_name;
                } else {
                    $full_name = $first_name . ' ' . $last_name;
                }

                Mail::send('emails.account_verification', [
                    'username' => $username,
                    'first_name' => $first_name,
                    'verification_code' => $verification_code
                ], function($message) use ($email_address, $full_name) {
                    $message->to($email_address, $full_name)->subject('F.A.D.P. Account Verification');
                });

                $this->setFlash('Success', 'Registration Successful. Please verify your account by clicking the link sent to your e-mail address.');

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
            if(Auth::user()->is_verified == true) {
                return redirect()->route('home.dashboard');
            } else {
                Auth::logout();

                $this->setFlash('Failed', 'Oops! Account not yet verified. Please verify your account by clicking the link sent to your e-mail address.');

                return redirect()->route('home.login');
            }
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

    public function verifyAccount($verification_code) {
        $account = AccountsModel::where('verification_code', $verification_code)->first();

        if($account) {
            if($account->is_verified == false) {
                $query = AccountsModel::where('id', $account->id)->update([
                    'is_verified' => true
                ]);

                if($query) {
                    $this->setFlash('Success', 'Account has been verified. You may now log in your account.');

                    return redirect()->route('home.login');
                } else {
                    $this->setFlash('Failed', 'Oops! Failed to verify account.');

                    return redirect()->route('home.login');
                }
            } else {
                $this->setFlash('Failed', 'Oops! Account has already been verified.');

                return redirect()->route('home.login');
            }
        } else {
            $this->setFlash('Failed', 'Oops! Verification code doesn\'t exist.');

            return redirect()->route('home.login');
        }
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
