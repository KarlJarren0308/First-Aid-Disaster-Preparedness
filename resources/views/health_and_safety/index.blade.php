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
                <li class="active"><a href="{{ route('health_and_safety.index') }}">Health & Safety</a></li>
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
            <div class="col-sm-4">
                <form data-form="search-form" action="{{ route('health_and_safety.index') }}" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Search For:</label>
                        <input id="search-field" type="text" class="form-control" name="search" autofocus>
                    </div>
                </form>
            </div>
            <div class="col-sm-8">
                <div class="cards">
                    @if(count($tips) > 0)
                        @foreach($tips as $tip)
                            <a href="{{ route('health_and_safety.show', ['year' => date('Y', strtotime($tip->created_at)), 'month' => date('m', strtotime($tip->created_at)), 'day' => date('d', strtotime($tip->created_at)), 'title' => str_replace(' ', '_', $tip->title)]) }}" class="card">
                                <div class="card-title">{{ $tip->title }}</div>
                                <div class="card-by">Posted by {{ $tip->username }} {{ $tip->elapsedCreatedAt() }}</div>
                                <div class="card-content">{!! nl2br(substr($tip->content, 0, 250) . (strlen($tip->content) > 250 ? '<span class="fa fa-ellipsis-h" style="color: #e74944; margin: 0 10px;" data-toggle="tooltip" data-placement="top" title="Read More..."></span>' : '')) !!}</div>
                            </a>
                        @endforeach

                        {{ $tips->links() }}
                    @else
                        <div class="card">
                            <div class="card-content">No result found.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
