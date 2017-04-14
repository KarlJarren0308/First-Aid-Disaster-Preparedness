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
                <h3 class="no-margin"><span class="fa fa-newspaper-o"></span> Manage News</h3>
                <hr>
                @include('partials.flash')
                <div class="form-group text-right">
                    <a href="{{ route('admin.news.add') }}" class="btn btn-primary"><span class="fa fa-plus"></span> Add</a>
                </div>
                <table class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Headline</th>
                            <th class="hidden-xs">Posted By</th>
                            <th>Date & Time Posted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $news_item)
                            <tr>
                                <td>{{ $news_item->id }}</td>
                                <td>{{ $news_item->headline }}</td>
                                <td class="hidden-xs">
                                    @if(strlen($news_item->accountInfo->userinfo->middle_name) > 1)
                                        {{ $news_item->accountInfo->userinfo->first_name . ' ' . substr($news_item->accountInfo->userinfo->middle_name, 0, 1) . '. ' . $news_item->accountInfo->userinfo->last_name }}
                                    @else
                                        {{ $news_item->accountInfo->userinfo->first_name . ' ' . $news_item->accountInfo->userinfo->last_name }}
                                    @endif
                                </td>
                                <td>
                                    <span class="visible-xs">{{ date('M. d, Y (h:iA)', strtotime($news_item->created_at)) }}</span>
                                    <span class="hidden-xs">{{ date('F d, Y (h:iA)', strtotime($news_item->created_at)) }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.news.edit', ['id' => $news_item->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-pencil"></span> Edit</a>
                                    <button data-button="delete-news-button" data-var-id="{{ $news_item->id }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span> Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="delete-news-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="fa fa-newspaper-o"></span> Delete News</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this news?</p>
                    <form data-form="delete-news-form" action="{{ route('admin.news.delete') }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="newsID" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="text-right">
                        <button class="yes-button btn btn-primary">Yes</button>
                        <button class="no-button btn btn-default">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('/js/admin/news.js') }}"></script>
@stop
