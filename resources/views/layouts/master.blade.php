<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Check your avalon import because reasons">
    <meta name="author" content="<3 Nicholas Johns">

    <title>Avalon Import Checker</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.5/sandstone/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }
        img .asset {
            display: block;
            max-width:500px;
            max-height:500px;
            width: auto;
            height: auto;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    @yield('content')
</div>
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="//craig.global.ssl.fastly.net/js/mousetrap/mousetrap.min.js?71631"></script>
@yield('appscripts')
</body>
</html>
