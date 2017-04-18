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
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->userInfo->first_name . ' ' . Auth::user()->userInfo->last_name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ route('home.profile') }}">Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('home.logout') }}">Logout</a></li>
                     </ul>
                </li>
            </ul>
        </div>
    </div>
    <div id="admin-page-wrapper">
        <div class="sidebar">
            <div id="sidebar-collapse" class="sidebar-nav navbar-collapse">
                <ul class="nav">
                    <li><a href="{{ route('admin.dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
                    <li class="active"><a href="{{ route('admin.news') }}"><span class="fa fa-newspaper-o"></span> Manage News</a></li>
                    <li><a href="{{ route('admin.users') }}"><span class="fa fa-users"></span> Manage Users</a></li>
                </ul>
            </div>
        </div>
        <div id="page-wrapper">
            <div class="visible-xs-block clearfix text-right">
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bars"></span>
                </button>
            </div>
            <div id="admin-container">
                <h3 class="no-margin"><span class="fa fa-newspaper-o"></span> Add News</h3>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="cards">
                            <a href="{{ route('admin.news') }}" class="card">
                                <div class="card-content">
                                    <span class="fa fa-arrow-left"></span> Go Back
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        @include('partials.flash')
                        <form data-form="add-news-form" action="{{ route('admin.news.add') }}" method="POST" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="form-group{{ ($errors->has('headline') ? ' has-error' : '') }}">
                                <label for="">Headline:</label>
                                <input type="text" class="form-control" name="headline" maxlength="255" value="{{ old('headline') }}" autofocus>
                                {!! $errors->first('headline', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group{{ ($errors->has('content') ? ' has-error' : '') }}">
                                <label for="">Content:</label>
                                <textarea rows="10" maxlength="10000" class="form-control no-resize" name="content">{{ old('content') }}</textarea>
                                {!! $errors->first('content', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary"><span class="fa fa-plus"></span> Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
