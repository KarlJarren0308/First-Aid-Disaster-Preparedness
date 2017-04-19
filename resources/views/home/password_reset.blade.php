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
                <li><a href="{{ route('home.donate') }}">Donate</a></li>
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
                        <h3 class="fg-white text-center no-margin">Password Reset</h3>
                    </div>
                    <div class="panel-body">
                        @include('partials.flash')
                        <form data-form="password-reset-form" action="{{ route('home.password_reset') }}" method="POST" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="form-group{{ ($errors->has('emailAddress') ? ' has-error' : '') }}">
                                <label for="">E-mail Address:</label>
                                <input type="email" class="form-control" name="emailAddress" value="{{ old('emailAddress') }}" autofocus>
                                {!! $errors->first('emailAddress', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group text-right">
                                <input type="submit" class="btn btn-primary" value="Reset Password">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
