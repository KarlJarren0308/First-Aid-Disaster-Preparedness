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
    <div id="main-container" class="container for-all">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="profile block shadow">
                    <div class="image">
                        <img src="/uploads/{{ $account->image }}">
                    </div>
                    <div class="content">
                        <div class="name">
                            @if(strlen($account->userInfo->middle_name) > 1)
                                {{ $account->userInfo->first_name . ' ' . substr($account->userInfo->middle_name, 0, 1) . '. ' . $account->userInfo->last_name }}
                            @else
                                {{ $account->userInfo->first_name . ' ' . $account->userInfo->last_name }}
                            @endif
                        </div>
                        <div class="additional-info"><span class="fa fa-{{ strtolower($account->userInfo->gender) }}"></span> {{ $account->userInfo->gender }}</div>
                    </div>
                </div>
                <div class="profile block shadow">
                    <div class="content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, nihil, culpa. Harum, consequuntur. Maiores itaque, consequuntur asperiores repellat, voluptatum ut harum expedita ex animi similique impedit inventore rem, ullam adipisci!
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
