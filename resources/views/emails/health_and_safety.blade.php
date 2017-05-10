@extends('layouts.email')

@section('content')
    <div class="block">
        <div class="header">
            <div class="title">First-aid & Disaster Preparedness</div>
            <div class="mini-title">Health & Safety Tips Alert</div>
        </div>
        <div class="content">
            <h2 class="no-margin">Hey {{ $first_name }},</h2>
            <div>
                <p>We've got a tip for you. Be sure to check it out.</p>
                <p>Click the link below to view the tip.<br><a href="{{ $tip_url }}">{{ $tip_url }}</a></p>
            </div>
        </div>
    </div>
@stop
