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
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->userInfo->first_name . ' ' . Auth::user()->userInfo->last_name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ route('home.profile', ['username' => Auth::user()->username]) }}">Profile</a></li>
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
                    <li><a href="{{ route('admin.news') }}"><span class="fa fa-newspaper-o"></span> Manage News</a></li>
                    <li><a href="{{ route('admin.health_and_safety') }}"><span class="fa fa-medkit"></span> Manage Health & Safety Tips</a></li>
                    <li><a href="{{ route('admin.users') }}"><span class="fa fa-users"></span> Manage Users</a></li>
                    <li class="active"><a href="{{ route('admin.self_test') }}"><span class="fa fa-stethoscope"></span> Manage Self Tests</a></li>
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
                <h3 class="no-margin"><span class="fa fa-stethoscope"></span> Add Self Test</h3>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="cards">
                            <a href="{{ route('admin.self_test') }}" class="card">
                                <div class="card-content">
                                    <span class="fa fa-arrow-left"></span> Go Back
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        @include('partials.flash')
                        <form data-form="add-news-form" action="{{ route('admin.news.add') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group{{ ($errors->has('self_test_for') ? ' has-error' : '') }}">
                                <label for="">Self Test For:</label>
                                <select name="self_test_for" class="form-control">
                                    <option value="" selected disabled>Select an option...</option>
                                    @foreach($tips as $tip)
                                        <option value="{{ $tip->id }}" @if(old('self_test_for') === $tip->id) selected @endif>{{ $tip->title }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('self_test_for', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="well">
                                <div class="panel shadow">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Question ID:</label>
                                                    <input type="text" class="form-control" class="question_id" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group{{ ($errors->has('question_type') ? ' has-error' : '') }}">
                                                    <label for="">Question Type:</label>
                                                    <select name="question_type" class="form-control">
                                                        <option value="" selected disabled>Select an option...</option>
                                                        <option value="Yes or No">Yes or No</option>
                                                        <option value="Multiple Choice">Multiple Choice</option>
                                                        <option value="Responses">Responses</option>
                                                    </select>
                                                    {!! $errors->first('question_type', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group{{ ($errors->has('question') ? ' has-error' : '') }}">
                                                    <label for="">Question:</label>
                                                    <input type="text" class="form-control" name="question" maxlength="255" value="{{ old('question') }}" autofocus>
                                                    {!! $errors->first('question', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Answer</th>
                                                    <th>Link Answer To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-group{{ ($errors->has('question') ? ' has-error' : '') }}">
                                                            <input type="text" class="form-control" name="question" maxlength="255" value="{{ old('question') }}" autofocus>
                                                            {!! $errors->first('question', '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group{{ ($errors->has('question') ? ' has-error' : '') }}">
                                                            <input type="text" class="form-control" name="question" maxlength="255" value="{{ old('question') }}" autofocus>
                                                            {!! $errors->first('question', '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
