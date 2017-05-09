@extends('layouts.master_main')

@section('content')
    <div class="navbar navbar-inverse navbar-fixed-top shadow no-margin">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home.index') }}">First-aid and Disaster Preparedness</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('health_and_safety.index') }}">Health & Safety</a></li>
                <li><a href="{{ route('news.index') }}">News</a></li>
                <li><a href="{{ route('home.help') }}">Help</a></li>
                <li><a href="{{ route('home.about') }}">About Us</a></li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li><a href="{{ route('home.login') }}">Login / Register</a></li>
            </ul>
        </div>
    </div>
    <div id="main-container" class="container for-all">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-primary shadow">
                    <div class="panel-heading">
                        <h3 class="fg-white text-center no-margin">Login</h3>
                    </div>
                    <div class="panel-body">
                        @include('partials.flash')
                        <form data-form="login-form" action="{{ route('home.login') }}" method="POST" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="">Username:</label>
                                <input type="text" class="form-control" name="username" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="">Password:</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-group text-right">
                                <div class="checkbox pull-left">
                                    <label for="remember-me">
                                        <input type="checkbox" id="remember-me" class="mark-control" name="rememberMe" value="true"> Remember Me
                                    </label>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Login">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-primary shadow">
                    <div class="panel-body text-center">
                        <div class="row">
                            <div class="col-sm-6">
                                Not yet a member? <a href="{{ route('home.register') }}">Register Here</a>
                            </div>
                            <div class="col-sm-6">
                                Forgot Password? <a href="{{ route('home.password_reset') }}">Click Here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
