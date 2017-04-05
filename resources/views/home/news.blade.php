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
    <div id="admin-page-wrapper" class="container-full">
        <div class="sidebar">
            <div id="sidebar-collapse" class="sidebar-nav navbar-collapse">
                <ul class="nav">
                    <li><a href="{{ route('home.dashboard') }}"><span class="fa fa-dashboard"></span> Dashboard</a></li>
                    <li class="active"><a href="{{ route('home.news') }}"><span class="fa fa-newspaper-o"></span> Manage News</a></li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <div id="page-wrapper">
            <div class="visible-xs-block clearfix text-right">
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bars"></span>
                </button>
            </div>
            <div id="admin-container">
                <h3 class="no-margin"><span class="fa fa-newspaper-o"></span> News</h3>
                <hr>
                @include('partials.flash')
                <div class="form-group text-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#add-news-modal"><span class="fa fa-plus"></span> Add</button>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Headline</th>
                            <th>Posted By</th>
                            <th>Date & Time Posted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $news_item)
                            <tr>
                                <td>{{ $news_item->id }}</td>
                                <td>{{ $news_item->headline }}</td>
                                <td>
                                    @if(strlen($news_item->accountInfo->userinfo->middle_name) > 1)
                                        {{ $news_item->accountInfo->userinfo->first_name . ' ' . substr($news_item->accountInfo->userinfo->middle_name, 0, 1) . '. ' . $news_item->accountInfo->userinfo->last_name }}
                                    @else
                                        {{ $news_item->accountInfo->userinfo->first_name . ' ' . $news_item->accountInfo->userinfo->last_name }}
                                    @endif
                                </td>
                                <td>{{ date('F d, Y (h:iA)', strtotime($news_item->created_at)) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-success btn-sm"><span class="fa fa-pencil"></span> Edit</button>
                                    <button class="btn btn-danger btn-sm"><span class="fa fa-trash"></span> Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="add-news-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span class="fa fa-plus"></span> Add News</h4>
                </div>
                <div class="modal-body">
                    <form data-form="add-news-form" action="{{ route('home.news') }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="action" value="Add">
                        <div class="form-group">
                            <label for="">Headline:</label>
                            <input type="text" class="form-control modal-focus" name="headline" maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="">Content:</label>
                            <textarea rows="3" maxlength="10000" class="form-control no-resize" name="content"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <input type="submit" class="btn btn-primary" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/home/news.js"></script>
@stop
