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
                <li class="active"><a href="{{ route('home.help') }}">Help</a></li>
                <li><a href="{{ route('home.about') }}">About Us</a></li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                @if(Auth::check())
                    @if(Auth::user()->type === 'administrator')
                        <li><a href="{{ route('admin.dashboard') }}">Go to Admin Page</a></li>
                    @endif
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->userInfo->first_name . ' ' . Auth::user()->userInfo->last_name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('home.profile', ['username' => Auth::user()->username]) }}">Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('home.logout') }}">Logout</a></li>
                         </ul>
                    </li>
                @else
                    <li><a href="{{ route('home.login') }}">Login / Register</a></li>
                @endif
            </ul>
        </div>
    </div>
    <div id="masthead" class="masthead">
        <div class="masthead-container">
            <div class="masthead-block text-center text-shadow">
                <h1 class="no-margin">We Can Make a Difference</h1>
                <h3>Let's help people affected by disasters.</h3>
            </div>
        </div>
    </div>
    <div id="main-container" class="container">
        <h1 class="no-margin">Help</h1>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="40%">Who to Call</th>
                    <th>Contact Information</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>National Disaster and Risk Reduction and Management Council (NDRRMC) Hotlines</td>
                    <td>
                        <strong>NDRRMC hotlines for Luzon</strong>
                        <ul>
                            <li>Office of Civil Defense - National Capital Region: (02) 421-1918/ (02) 913-2786</li>
                            <li>Office of Civil Defense - Region I: (072) 607-6528</li>
                            <li>Office of Civil Defense - Region IV-A: (049) 531-7266</li>
                            <li>NDRRMC Region IV-B: (043) 723-4248</li>
                            <li>NDRRMC - Cordillera Administrative Region: (074) 304-2256, (074) 619-0986, (074) 444-5298, (074) 619-0986</li>
                        </ul>
                        <strong>Office of the Civil Defense regional office telephone directory</strong>
                        <ul>
                            <li>Region I: (072) 607-6528, (072) 700-4747</li>
                            <li>Region II: (078) 304-1630, (078) 304-1631</li>
                            <li>Region III: (045) 455-1526, (045) 455-0033</li>
                            <li>Region IV-A: (049) 834-4344, (049) 531-7266, TF (049)531-7279</li>
                            <li>Region IV-B: (043) 723-4248, (043) 702-9361</li>
                            <li>Region V: (052) 742-1176, +63917-574-7880 (Globe), +63928-505-3861 (Smart)</li>
                            <li>Region VI: (033) 336-9353, (033) 337-6671, (033) 509-7319</li>
                            <li>Region VII: (032) 416-5025, (032) 253-6162, (032) 253-8730, +63917-947-5666 (Globe), +63949-471-0009 (Smart)</li>
                            <li>Region VIII: +63917-700-1121 (Globe), +63915-762-2368 (Globe), +6306-402-7737 (Globe) TEXT FIRST BEFORE CALLING THIS LINE</li>
                            <li>Region IX: (062) 911-1631, (062) 925-0458, (062) 9913450</li>
                            <li>Region X: (088) 857-3907, (088) 857-3988 (Telefax)</li>
                            <li>Region XI: (082) 233-0295, (082) 233-0611 (Telefax)</li>
                            <li>Region XII: (083) 552-9759, (083) 553-2994, (083) 301-2994, +63917-628-3720 (Globe), +63920-976-4001 (Smart)</li>
                            <li>CAR: (074) 3042256, (074) 6190986, (074) 4445298</li>
                            <li>CARAGA: (085) 342-8753</li>
                            <li>National Capital Region: (02) 913-2786 or (02) 421-1918</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Red Cross</td>
                    <td>
                        <ul>
                            <li>Hotline: 143, (02) 527-0000, (02) 527-8385 to 95</li>
                            <li>Disaster Management Office: 134 (Staff), 132 (Manager), 133 (Radio Room)</li>
                            <li>Telefax: 527-0864</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Philippine National Police (PNP) Hotline Patrol</td>
                    <td>
                        <ul>
                            <li>Hotline: 117, 722-0650</li>
                            <li>Text hotline: 0917-847-5757</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Bureau of Fire Protection (NCR)</td>
                    <td>
                        <ul>
                            <li>Direct line: (02) 426-0219, (02) 426-3812, (02)426-0246</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Philippine Coast Guard</td>
                    <td>
                        <ul>
                            <li>Trunkline: (02) 527-8481 to 89</li>
                            <li>Action center: (02) 527-3877, 0917-PCG-DOTC 0917-724-3682 (Globe), 0918-967-4697</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Metro Manila Development Authority (MMDA)</td>
                    <td>
                        <ul>
                            <li>Hotline: 136</li>
                            <li>Trunkline: (02) 882-4150-77, loc. 337 (rescue), 255 (Metrobase), 319 (Road Safety), 374 (Public Safety), 320 (Road Emergency), (02) 882-0925 (Flood Control)</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Philippine Atmospheric, Geophysical, and Astronomical Services Administration (PAGASA) Hotline</td>
                    <td>
                        <ul>
                            <li>General Inquiries (Public Information Unit): (632) 434-2696</li>
                            <li>Weather Updates (Weather Forecasting Section): (632) 926-4258, (632) 927-1541</li>
                            <li>Aviation Weather Updates (Aeronautical Meteorology Service Section): (632) 832-3023</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>PHIVOLCS</td>
                    <td>
                        <ul>
                            <li>Trunkline: (02) 426-1468 to 79, local 124/125 (Seismology)</li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@stop
