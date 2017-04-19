@extends('layouts.email')

@section('content')
    <div class="block">
        <div class="header">
            <div class="title">First-aid & Disaster Preparedness</div>
            <div class="mini-title">Account Verification</div>
        </div>
        <div class="content">
            <h2 class="no-margin">Welcome {{ $first_name }},</h2>
            <div>
                <p>Thank you for joining the First-aid & Disaster Preparedness.</p>
                <p>Click the link below to verify your account.<br><a href="{{ url('/verify_account/' . $verification_code) }}">{{ url('/verify_account/' . $verification_code) }}</a></p>
            </div>
        </div>
    </div>
@stop
