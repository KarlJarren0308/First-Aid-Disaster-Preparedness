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
                    <li class="active"><a href="{{ route('admin.users') }}"><span class="fa fa-users"></span> Manage Users</a></li>
                    <li><a href="{{ route('admin.self_test') }}"><span class="fa fa-stethoscope"></span> Manage Self Tests</a></li>
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
                <h3 class="no-margin"><span class="fa fa-users"></span> Manage Users</h3>
                <hr>
                @include('partials.flash')
                <table class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th class="hidden-xs">Date & Time Created</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>{{ $account->username }}</td>
                                <td>
                                    @if(strlen($account->userinfo->middle_name) > 1)
                                        {{ $account->userinfo->first_name . ' ' . substr($account->userinfo->middle_name, 0, 1) . '. ' . $account->userinfo->last_name }}
                                    @else
                                        {{ $account->userinfo->first_name . ' ' . $account->userinfo->last_name }}
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    <span>{{ date('F d, Y (h:iA)', strtotime($account->created_at)) }}</span>
                                </td>
                                <td class="text-center">
                                    @if($account->type === 'user')
                                        @if($account->is_banned)
                                            <button data-button="unban-users-button" data-var-id="{{ $account->id }}" class="btn btn-danger btn-sm"><span class="fa fa-refresh"></span> Unban</button>
                                        @else
                                            <button data-button="ban-users-button" data-var-id="{{ $account->id }}" class="btn btn-danger btn-sm"><span class="fa fa-ban"></span> Ban</button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="unban-users-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="fa fa-newspaper-o"></span> Delete User</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to unban this user? Unbanned users will be able to do the following:</p>
                    <ul>
                        <li>Comment on news.</li>
                    </ul>
                    <form data-form="unban-users-form" action="{{ route('admin.users.unban') }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="accountID" value="">
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
    <div id="ban-users-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="fa fa-newspaper-o"></span> Delete User</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to ban this user? Banned users won't be able to do the following:</p>
                    <ul>
                        <li>Comment on news.</li>
                    </ul>
                    <form data-form="ban-users-form" action="{{ route('admin.users.ban') }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="accountID" value="">
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
    <script src="{{ url('/js/admin/users.js') }}"></script>
@stop
