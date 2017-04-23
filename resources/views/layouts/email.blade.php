<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>First-aid & Disaster Preparedness</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Merriweather');
        @import url('https://fonts.googleapis.com/css?family=Roboto');

        #body {
            background-color: #e74944;
            color: #222;
            font-family: 'Roboto', 'Helvetica', sans-serif;
            font-size: 20px;
            padding: 0;
            margin: 0;
        }

        .block {
            background-color: white;
            border-top: 1px solid #bbb;
            border-bottom: 3px solid #bbb;
            border-left: 1px solid #bbb;
            border-right: 1px solid #bbb;
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
            border-bottom: 1px solid #bbb;
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

        .list {
            border-top: 1px solid #bbb;
            border-bottom: 3px solid #bbb;
            border-left: 1px solid #bbb;
            border-right: 1px solid #bbb;
            padding: 0;
            margin-bottom: 0;
        }

        .list > li {
            list-style-type: none;
        }

        .list > li:nth-child(odd) {
            background-color: white;
        }

        .list > li:nth-child(even) {
            background-color: #eee;
        }

        .list > li > a {
            color: #222;
            display: inline-block;
            text-decoration: none;
            padding: 10px 15px;
            width: 100%;
            box-sizing: border-box;
        }

        .list > li > a > .header > .title {
            font-size: 25px;
            font-weight: bold;
        }

        .list > li > a > .header > .mini-title {
            font-size: 12px;
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
    <div id="body">
    @yield('content')
    </div>
</body>
</html>
