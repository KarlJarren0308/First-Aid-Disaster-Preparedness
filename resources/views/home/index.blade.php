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
                @if(Auth::check())
                    @if(Auth::user()->type === 'administrator')
                        <li><a href="{{ route('admin.dashboard') }}">Go to Admin Page</a></li>
                    @endif
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->userInfo->first_name . ' ' . Auth::user()->userInfo->last_name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('home.profile', ['username' => Auth::user()->username]) }}">Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('home.logout') }}">Logout</a></li>
                         </ul>
                    </li>
                @else
                    <li><a href="{{ route('home.login') }}">Login / Register</a></li>
                @endif
            </ul>
        </div>
    </div>
    <div id="masthead" class="masthead">
        <div class="masthead-container">
            <div class="masthead-block text-center text-shadow">
                <h1 class="no-margin">We Can Make a Difference</h1>
                <h3>Let's help people affected by disasters.</h3>
            </div>
        </div>
    </div>
    <div id="main-container" class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-primary text-center">
                    <div class="panel-body">
                        <span class="fa fa-medkit fa-5x text-danger"></span>
                        <h3 class="no-margin">Health & Safety</h3>
                    </div>
                    <div class="panel-footer">
                        <strong>Know all the health & safety tips, from giving first aid to disaster preparedness.</strong>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-primary text-center">
                    <div class="panel-body">
                        <span class="fa fa-bullhorn fa-5x text-danger"></span>
                        <h3 class="no-margin">News</h3>
                    </div>
                    <div class="panel-footer">
                        <strong>Be informed by latest news & events.</strong>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-primary text-center">
                    <div class="panel-body">
                        <span class="fa fa-question-circle fa-5x text-danger"></span>
                        <h3 class="no-margin">Help</h3>
                    </div>
                    <div class="panel-footer">
                        <strong>Don't know who to call in case of emergency? We got their contact information.</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
