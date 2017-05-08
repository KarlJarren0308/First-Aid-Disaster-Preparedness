<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\UtilityHelpers;
use App\Http\Requests\RegisterRequest;

use Auth;
use Mail;
use Validator;

use App\AccountsModel;
use App\UsersModel;

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

    public function profile($username) {
        $account = AccountsModel::where('username', $username)->first();

        if($account) {
            return view('home.profile', [
                'account' => $account
            ]);
        } else {
            return view('errors.404');
        }
    }

    public function register()
    {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return view('home.register');
        }
    }

    public function login()
    {
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return view('home.login');
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
        if(Auth::check()) {
            if(Auth::user()->type === 'administrator') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return view('home.password_reset');
        }
    }

    public function changePassword($password_reset_code) {
        $account = AccountsModel::where('password_reset_code', $password_reset_code)->first();

        if($account) {
            return view('home.change_password', [
                'password_reset_code' => $password_reset_code
            ]);
        } else {
            $this->setFlash('Failed', 'Oops! Invalid password reset code.');

            return redirect()->route('home.password_reset');
        }
    }

    public function postRegister(RegisterRequest $request)
    {
        $username = $request->input('username');
        $email_address = $request->input('emailAddress');
        $first_name = $request->input('firstName');
        $middle_name = $request->input('middleName');
        $last_name = $request->input('lastName');
        $image = $request->hasFile('image', null);
        $verification_code = $this->generateCode($username);

        if($image !== null) {
            $imageName = $username .  '_profile.' . $image->getClientOriginalExtension();
        } else {
            $imageName = null;
        }

        $account_id = AccountsModel::insertGetId([
            'username' => $username,
            'email_address' => $email_address,
            'password' => bcrypt($request->input('password')),
            'image' => $imageName,
            'verification_code' => $verification_code,
            'created_at' => date('Y-m-d')
        ]);

        if($account_id) {
            $user_id = UsersModel::insertGetId([
                'id' => $account_id,
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'gender' => $request->input('gender'),
                'mobile_number' => $request->input('mobileNumber'),
                'birth_date' => $request->input('birthDate'),
                'created_at' => date('Y-m-d')
            ]);

            if($user_id) {
                if(strlen($middle_name) > 1) {
                    $full_name = $first_name . ' ' . substr($middle_name, 0, 1) . '. ' . $last_name;
                } else {
                    $full_name = $first_name . ' ' . $last_name;
                }

                if($image !== null) {
                    $image->move('uploads', $imageName);
                }

                Mail::queue('emails.account_verification', [
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

    public function postLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $rememberMe = (boolean) $request->input('rememberMe', false);

        $credentials = [
            'username' => $username,
            'password' => $password
        ];

        if(Auth::attempt($credentials, $rememberMe)) {
            if(Auth::user()->is_verified == true) {
                if(Auth::user()->type === 'administrator') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('news.index');
                }
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

    public function postPasswordReset(Request $request) {
        $result = Validator::make($request->all(), [
            'emailAddress' => 'required|email|exists:accounts,email_address'
        ]);

        if($result->fails()) {
            return redirect()->route('home.password_reset')->withErrors($result)->withInput();
        } else {
            $account = AccountsModel::where('email_address', $request->input('emailAddress'))->first();

            if($account) {
                if(strlen($account->userInfo->middle_name) > 1) {
                    $full_name = $account->userInfo->first_name . ' ' . substr($account->userInfo->middle_name, 0, 1) . '. ' . $account->userInfo->last_name;
                } else {
                    $full_name = $account->userInfo->first_name . ' ' . $account->userInfo->last_name;
                }

                $password_reset_code = $this->generateCode($account->username);

                $query = AccountsModel::where('id', $account->id)->update([
                    'password_reset_code' => $password_reset_code
                ]);

                if($query) {
                    Mail::queue('emails.password_reset', [
                        'first_name' => $account->userInfo->first_name,
                        'password_reset_code' => $password_reset_code
                    ], function($message) use ($account, $full_name) {
                        $message->to($account->email_address, $full_name)->subject('F.A.D.P. Password Reset');
                    });

                    $this->setFlash('Success', 'A change password link has been sent to your e-mail address.');

                    return redirect()->route('home.password_reset');
                } else {
                    $this->setFlash('Failed', 'Oops! Failed to send change password link to your e-mail address.');

                    return redirect()->route('home.password_reset');
                }
            } else {
                $this->setFlash('Failed', 'Oops! E-mail address not registered.');

                return redirect()->route('home.password_reset');
            }
        }
    }

    public function postChangePassword($password_reset_code, Request $request) {
        $result = Validator::make($request->all(), [
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|min:4'
        ]);

        if($result->fails()) {
            return redirect()->route('home.change_password', [
                'password_reset_code' => $password_reset_code
            ])->withErrors($result)->withInput();
        } else {
            $query = AccountsModel::where('password_reset_code', $password_reset_code)->update([
                'password' => bcrypt($request->input('password')),
                'password_reset_code' => null
            ]);

            if($query) {
                $this->setFlash('Success', 'Password has been changed. You may now log in your account.');

                return redirect()->route('home.login');
            } else {
                $this->setFlash('Failed', 'Oops! Failed to change password.');

                return redirect()->route('home.change_password', [
                    'password_reset_code' => $password_reset_code
                ]);
            }
        }
    }
}
