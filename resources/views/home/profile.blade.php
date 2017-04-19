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
                @if(Auth::check())
                    @if(Auth::user()->type === 'administrator')
                        <li><a href="{{ route('admin.dashboard') }}">Go to Admin Page</a></li>
                    @endif
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->userInfo->first_name . ' ' . Auth::user()->userInfo->last_name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('home.profile') }}">Profile</a></li>
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
    <div id="main-container" class="container for-all">
        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi incidunt ad magni impedit ratione voluptatum, at ex quidem! Fugit saepe eius, reprehenderit autem consequatur incidunt, necessitatibus doloremque rem itaque quod?</div>
    </div>
@stop
