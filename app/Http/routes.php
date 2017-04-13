<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['as' => 'home.'], function() {
    Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
    Route::get('donate', ['as' => 'donate', 'uses' => 'HomeController@donate']);
    Route::get('help', ['as' => 'help', 'uses' => 'HomeController@help']);
    Route::get('about', ['as' => 'about', 'uses' => 'HomeController@about']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'HomeController@logout']);
    Route::get('register', ['as' => 'register', 'uses' => 'HomeController@register']);
    Route::get('password_reset', ['as' => 'password_reset', 'uses' => 'HomeController@passwordReset']);
    Route::get('login', ['as' => 'login', 'uses' => 'HomeController@login']);
    Route::get('verify_account/{verification_code}', ['as' => 'verify_account', 'uses' => 'HomeController@verifyAccount']);

    Route::group(['middleware' => 'auth'], function() {
        Route::get('profile', ['as' => 'profile', 'uses' => 'HomeController@profile']);
    });

    Route::post('login', ['as' => 'login', 'uses' => 'HomeController@postLogin']);
    Route::post('register', ['as' => 'register', 'uses' => 'HomeController@postRegister']);
    Route::post('password_reset', ['as' => 'password_reset', 'uses' => 'HomeController@postPasswordReset']);
});

Route::group(['as' => 'admin.'], function() {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('admin/dashboard', ['as' => 'dashboard', 'uses' => 'AdminController@dashboard']);
        Route::get('admin/news', ['as' => 'news', 'uses' => 'AdminController@news']);

        Route::post('admin/news', ['as' => 'news', 'uses' => 'AdminController@postNews']);
    });
});

Route::group(['as' => 'news.'], function() {
    Route::get('news', ['as' => 'index', 'uses' => 'NewsController@index']);
    Route::get('news/{id}', ['as' => 'show', 'uses' => 'NewsController@show']);

    Route::post('news', ['as' => 'index', 'uses' => 'NewsController@index']);
    Route::post('news/comment', ['as' => 'comment', 'uses' => 'NewsController@postComment']);
    Route::post('news/comment/captcha', ['as' => 'captcha', 'uses' => 'NewsController@postCommentCaptcha']);
    Route::post('news/comments', ['as' => 'comments', 'uses' => 'NewsController@comments']);
});
