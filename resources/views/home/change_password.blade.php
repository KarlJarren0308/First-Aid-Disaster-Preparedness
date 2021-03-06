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
            <a class="navbar-brand" href="{{ route('home.index') }}">First-aid & Disaster Preparedness</a>
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
                        <h3 class="fg-white text-center no-margin">Change Password</h3>
                    </div>
                    <div class="panel-body">
                        @include('partials.flash')
                        <form data-form="change-password-form" action="{{ route('home.change_password', ['password_reset_code' => $password_reset_code]) }}" method="POST" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="form-group{{ ($errors->has('password') ? ' has-error' : '') }}">
                                <label for="">New Password:</label>
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}" autofocus>
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group{{ ($errors->has('password_confirmation') ? ' has-error' : '') }}">
                                <label for="">Confirm New Password:</label>
                                <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group text-right">
                                <input type="submit" class="btn btn-primary" value="Save Changes">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
