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
                        <h3 class="fg-white text-center no-margin">Register</h3>
                    </div>
                    <div class="panel-body">
                        @include('partials.flash')
                        <form data-form="register-form" action="{{ route('home.register') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-center form-group{{ ($errors->has('image') ? ' has-error' : '') }}">
                                        <input id="image" type="file" class="image-upload" name="image" value="{{ old('image') }}" accept="image/*">
                                        <label class="image-uploader" for="image">
                                            <span class="fa fa-plus"></span>
                                            <img class="image-upload-preview" src="#">
                                        </label>
                                        <div class="label-mark">Set your Profile Picture</div>
                                        {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group{{ ($errors->has('username') ? ' has-error' : '') }}">
                                        <label for="">Username:</label>
                                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" autofocus>
                                        {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ ($errors->has('password') ? ' has-error' : '') }}">
                                        <label for="">Password:</label>
                                        <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ ($errors->has('password_confirmation') ? ' has-error' : '') }}">
                                        <label for="">Confirm Password:</label>
                                        <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                        {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group{{ ($errors->has('firstName') ? ' has-error' : '') }}">
                                        <label for="">First Name:</label>
                                        <input type="text" class="form-control" name="firstName" value="{{ old('firstName') }}">
                                        {!! $errors->first('firstName', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Middle Name:</label>
                                        <input type="text" class="form-control" name="middleName" value="{{ old('middleName') }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group{{ ($errors->has('lastName') ? ' has-error' : '') }}">
                                        <label for="">Last Name:</label>
                                        <input type="text" class="form-control" name="lastName" value="{{ old('lastName') }}">
                                        {!! $errors->first('lastName', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group{{ ($errors->has('emailAddress') ? ' has-error' : '') }}">
                                        <label for="">E-mail Address:</label>
                                        <input type="email" class="form-control" name="emailAddress" value="{{ old('emailAddress') }}">
                                        {!! $errors->first('emailAddress', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ ($errors->has('gender') ? ' has-error' : '') }}">
                                        <label for="">Gender:</label>
                                        <select name="gender" class="form-control">
                                            <option value="" selected disabled>Select an option...</option>
                                            <option value="Male" @if(old('gender') === 'Male') selected @endif>Male</option>
                                            <option value="Female" @if(old('gender') === 'Female') selected @endif>Female</option>
                                        </select>
                                        {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ ($errors->has('birthDate') ? ' has-error' : '') }}">
                                        <label for="">Birth Date:</label>
                                        <input type="date" class="form-control" name="birthDate" value="{{ old('birthDate') }}">
                                        {!! $errors->first('birthDate', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <input type="submit" class="btn btn-primary" value="Register">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('/js/home/profile_picture_uploader.js') }}"></script>
@stop
