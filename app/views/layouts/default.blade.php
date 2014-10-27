<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Metas -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            @section('title')
            Laravel 4 Sample Site
            @show
        </title>
        @section('meta_keywords')
        <meta name="keywords" content="your, awesome, keywords, here" />
        @show
        @section('meta_author')
        <meta name="author" content="Jon Doe" />
        @show
        @section('meta_description')
        <meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />
        @show
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS -->
        {{ HTML::style('assets/css/bootstrap.min.css') }}
        {{ HTML::style('assets/css/bootstrap-theme.min.css') }}
        {{ HTML::style('assets/css/dataTables.bootstrap.css') }}
        {{ HTML::style('assets/css/bootstrap-switch.min.css') }}
        {{ HTML::style('assets/css/select2.css') }}
        {{ HTML::style('assets/css/select2-bootstrap.css') }}
        {{ HTML::style('assets/css/custom.css') }}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Javascripts -->
        {{ HTML::script('assets/js/jquery-2.1.1.min.js') }}
        {{ HTML::script('assets/js/bootstrap.min.js') }}
        {{ HTML::script('assets/js/jquery.dataTables.min.js') }}
        {{ HTML::script('assets/js/dataTables.bootstrap.js') }}
        {{ HTML::script('assets/js/bootstrap-switch.min.js') }}
        {{ HTML::script('assets/js/select2.min.js') }}
        {{ HTML::script('assets/js/init.js') }}

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{{ asset('assets/images/favicon.png') }}}">
    </head>

    <body>
        <!-- To make sticky footer need to wrap in a div -->
        <div id="wrap">
            <!-- Top menu -->
            @include('layouts.partials.nav')
            <!-- ./ top menu -->

            <!-- Container -->
            <div class="container">
                <!-- Messages -->
                @include('flash::message')
                <!-- ./ messages -->

                <!-- Content -->
                @yield('content')
                <!-- ./ content -->
            </div>
            <!-- ./ container -->

        </div>
        <!-- ./wrap -->
    </body>
</html>
