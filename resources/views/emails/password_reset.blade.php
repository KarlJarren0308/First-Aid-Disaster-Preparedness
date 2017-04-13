@extends('layouts.email')

@section('content')
    <div class="block">
        <div class="header">
            <div class="title">First-aid & Disaster Preparedness</div>
            <div class="mini-title">Password Reset</div>
        </div>
        <div class="content">
            <h2 class="no-margin">Hi {{ $first_name }},</h2>
            <div>
                <p>Did you forgot your password? No worries, we'll help you set a new password for your account.</p>
                <p>Click the link below to change your password.<br><a href="{{ url('/change_password/' . $password_reset_code) }}">{{ url('/change_password/' . $password_reset_code) }}</a></p>
            </div>
        </div>
    </div>
@stop
