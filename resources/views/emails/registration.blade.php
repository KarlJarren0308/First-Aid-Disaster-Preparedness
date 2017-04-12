@extends('layouts.master_main')

@section('content')
    <div class="navbar navbar-inverse navbar-static-top shadow no-margin">
        <div class="navbar-header">
            <span class="navbar-brand">First-aid & Disaster Preparedness</span>
        </div>
    </div>
    <div id="main-container" class="container">
        <div class="panel panel-primary shadow">
            <div class="panel-heading">
                <h3 class="fg-white text-center no-margin">Account Verification</h3>
            </div>
            <div class="panel-body">
                <h4 class="no-margin">Welcome {{ $first_name }},</h4>
                <hr>
                <div>
                    <p>Thank you for joining the First-aid & Disaster Preparedness.</p>
                    <p>Click the link below to sign in and activate your account.<br><a href="{{ url('/verify_account/' . $verification_code) }}">{{ url('/verify_account/' . $verification_code) }}</a></p>
                </div>
            </div>
        </div>
    </div>
@stop
