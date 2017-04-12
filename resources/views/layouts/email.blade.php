<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
@yield('meta')
    <title>First-aid & Disaster Preparedness</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Merriweather');
        @import url('https://fonts.googleapis.com/css?family=Roboto');
    </style>
    <style>
        html,
        body {
            padding: 0;
            margin: 0;
        }

        body {
            background-color: #f8f8f8;
            color: #222;
            font-family: 'Roboto', 'Helvetica', sans-serif;
            font-size: 20px;
        }

        .block {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: inline-block;
            padding: 25px;
            margin: 50px 10%;
            width: 80%;
            box-sizing: border-box;
        }

        .block > .header,
        .block > .content {
            word-wrap: break-word;
        }

        .block > .header {
            display: block;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .block > .header > .title {
            font-family: 'Merriweather';
            font-size: 1.75em;
            font-weight: bold;
        }

        .block > .header > .mini-title {
            font-size: 1.25em;
        }

        .block > .content {
            padding: 25px;
        }

        .no-padding {
            padding-top: 0;
            padding-bottom: 0;
            padding-left: 0;
            padding-right: 0;
        }

        .no-margin {
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 0;
            margin-right: 0;
        }
    </style>
</head>
<body>
@yield('content')
</body>
</html>
