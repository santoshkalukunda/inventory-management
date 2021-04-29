<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>@yield('title') | Inventory System</title>
    <link type="image/x-icon" href="{{asset('assets/img/icon.png')}}" rel="shortcut icon" />

    @include('layouts.partials.style')
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        @include('layouts.partials.nav')
        <!-- START SIDEBAR-->
        @include('layouts.partials.sidebar')

        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                <div class="mr-lg-3 mr-0">
                    @include('alerts.all')
                    
                    @yield('content')
                    <!-- END PAGE CONTENT-->
                </div>
            </div>
            @include('layouts.partials.footer')
        </div>
    </div>

    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    @include('layouts.partials.script')

</body>

</html>