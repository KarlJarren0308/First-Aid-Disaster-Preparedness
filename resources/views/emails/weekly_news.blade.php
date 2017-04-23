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
                <p>Here are the news posted this week. Hope you didn't miss any of them.</p>
                <ul class="list">
                    @foreach($news as $news_item)
                        <li>
                            <a href="">
                                <div class="header">
                                    <div class="title">{{ $news_item['headline'] }}</div>
                                    <div class="mini-title">Posted by {{ $news_item['username'] }} {{ $news_item['elapsedCreatedAt'] }}</div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop
