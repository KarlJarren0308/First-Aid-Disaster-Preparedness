@extends('layouts.email')

@section('content')
<div class="block">
    <div class="header">
        <div class="title">First-aid & Disaster Preparedness</div>
        <div class="mini-title">News Alert</div>
    </div>
    <div class="content">
        <h2 class="no-margin">Hey {{ $first_name }},</h2>
        <div>
            <p>We've got some news for you. Be sure to check it out.</p>
            <p>Click the link below to view the news.<br><a href="{{ url('/news/' . $year . '/' . $month . '/' . $day . '/' . $headline) }}">{{ url('/news/' . $year . '/' . $month . '/' . $day . '/' . $headline) }}</a></p>
        </div>
    </div>
</div>
@stop
