@extends('layouts.master_main')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $tip->title }}" />
    <meta property="og:description" content="{{ substr($tip->content, 0, 250) . (strlen($tip->content) > 250 ? '...' : '') }}" />
    <meta name="description" content="{{ substr($tip->content, 0, 250) . (strlen($tip->content) > 250 ? '...' : '') }}" />
    <meta name="keywords" content="F.A.D.P." />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:url" content="{{ url('/') }}" />
    <meta name="twitter:title" content="{{ $tip->title }}" />
    <meta name="twitter:description" content="{{ substr($tip->content, 0, 250) . (strlen($tip->content) > 250 ? '...' : '') }}" />
@stop

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
                        <input id="search-field" type="text" class="form-control" name="search" required>
                    </div>
                </form>
            </div>
            <div class="col-sm-8">
                <div class="cards">
                    <a href="{{ route('health_and_safety.index') }}" class="card">
                        <div class="card-content">
                            <span class="fa fa-arrow-left"></span> Go Back
                        </div>
                    </a>
                    <div id="health-and-safety-block" class="card" data-var-id="{{ $tip->id }}">
                        <div class="card-title">{{ $tip->title }}</div>
                        <div class="card-by">Posted by {{ $tip->username }}  {{ $tip->elapsedCreatedAt() }}</div>
                        <div class="card-content">
                            <div>{!! nl2br($tip->content) !!}</div>
                            @if(count($tip->media) > 0)
                                <div id="media-carousel" class="media carousel" data-interval="false">
                                    <ol class="carousel-indicators">
                                        @foreach($tip->media as $key => $media)
                                            <li data-target="#media-carousel" data-slide-to="{{ $key }}"{!! ($key === 0 ? ' class="active"' : '') !!}></li>
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach($tip->media as $key => $media)
                                            @if(in_array(strtolower(pathinfo($media->filename, PATHINFO_EXTENSION)), ['mp4', 'webm', 'ogg']))
                                                <div class="item{{ ($key === 0 ? ' active' : '') }}">
                                                    <video src="{{ url('/uploads/' . $media->filename) }}" controls></video>
                                                </div>
                                            @else
                                                <div class="item{{ ($key === 0 ? ' active' : '') }}">
                                                    <img src="{{ url('/uploads/' . $media->filename) }}">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    @if(count($tip->media) > 1)
                                        <a class="left carousel-control" href="#media-carousel" data-slide="prev">
                                            <span class="fa fa-chevron-left"></span>
                                        </a>
                                        <a class="right carousel-control" href="#media-carousel" data-slide="next">
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                            @if($self_test !== null)
                                <div class="text-center" style="margin-top: 25px;">
                                    <button class="btn btn-primary start-self-test-button">Start Self Test</button>
                                    <div class="self-tests">
                                        @foreach(json_decode($self_test->questions) as $question)
                                            <div class="self-test-page">
                                                <div class="self-test-question">{{ $question }}</div>
                                                <div class="self-test-answer">
                                                    <div class="btn-group btn-group-justified">
                                                        <div class="btn-group btn-group-lg">
                                                            <button class="btn btn-primary yes-button">Yes</button>
                                                        </div>
                                                        <div class="btn-group btn-group-lg">
                                                            <button class="btn btn-default no-button">No</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="self-test-page">
                                            <h2 class="self-test-result"></h2>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <ul class="tabs">
                                <li class="active"><a href="#comment" class="tab">Comment</a></li>
                                <li><a href="#share" class="tab">Share</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="comment">
                                    <div class="block" style="margin-bottom: 10px;">
                                        @if(Auth::check())
                                            @if(Auth::user()->is_banned)
                                                <div class="content">Oops! You have been banned from commenting. Please contact the administrator.</div>
                                            @else
                                                <div class="image">
                                                    <img src="{{ url('/uploads/' . (Auth::user()->image !== null ? Auth::user()->image : 'fadp_anonymous.png')) }}" class="round">
                                                </div>
                                                <div class="content">
                                                    <form id="comment-form" data-form="comment-form" autocomplete="off">
                                                        <input type="hidden" name="healthAndSafetyID" value="{{ $tip->id }}">
                                                        <div class="form-group no-margin">
                                                            <input type="text" class="form-control" name="comment" maxlength="2000" placeholder="Write a comment..." required autofocus>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        @else
                                            <div class="content">Oops! Only users who have logged in are allowed to leave a comment on this news.</div>
                                        @endif
                                    </div>
                                    <div id="comments-block" class="block-list"></div>
                                </div>
                                <div class="tab-pane" id="share">
                                    <!-- <div class="form-group">
                                        <input type="text" class="form-control" value="{{ route('health_and_safety.show', ['year' => date('Y', strtotime($tip->created_at)), 'month' => date('m', strtotime($tip->created_at)), 'day' => date('d', strtotime($tip->created_at)), 'title' => str_replace(' ', '_', $tip->title)]) }}">
                                    </div> -->
                                    <div class="share-list">
                                        <div class="fb-share-button" data-href="{{ route('health_and_safety.show', ['year' => date('Y', strtotime($tip->created_at)), 'month' => date('m', strtotime($tip->created_at)), 'day' => date('d', strtotime($tip->created_at)), 'title' => str_replace(' ', '_', $tip->title)]) }}" data-layout="button" data-size="large"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="captcha-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span class="fa fa-hand-paper-o"></span> reCAPTCHA</h4>
                </div>
                <div class="modal-body">
                    <form id="captcha-form" data-form="captcha-form">
                        {!! app('captcha')->display(); !!}
                        <div class="form-group text-right">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('/js/facebook-sdk.js') }}"></script>
    <script src="{{ url('/js/health_and_safety/show.js') }}"></script>
@stop
