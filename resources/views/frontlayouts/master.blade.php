<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!---Title-->
    <title>Galleria - Home-1</title>
    <!--Google Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,500,600,800,700' rel='stylesheet' type='text/css'>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!--Bootstrap CSS-->
    <link href="{{ url('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--Font awsome CSS-->
    <link href="{{ url('front') }}/css/font-awesome.min.css" rel="stylesheet">
    <!--Meanmenu CSS-->
    <link href="{{ url('front') }}/css/meanmenu.min.css" rel="stylesheet">
    <!--Rev Slider CSS-->
    <link href="{{ url('front') }}/rs-plugin/css/settings.css" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link href="{{ url('front') }}/css/owl.carousel.css" rel="stylesheet">
    <link href="{{ url('front') }}/css/owl.theme.css" rel="stylesheet">
    <link href="{{ url('front') }}/css/owl.transitions.css" rel="stylesheet">
    <!--Jquery UI CSS-->
    <link href="{{ url('front') }}/css/jquery-ui.css" rel="stylesheet">
    <!--Normalize CSS-->
    <link href="{{ url('front') }}/css/normalize.css" rel="stylesheet">
    <!--Main Style CSS-->
    <link href="{{ url('front') }}/style.css" rel="stylesheet">
    <!--Responsive CSS-->
    <link href="{{ url('front') }}/css/responsive.css" rel="stylesheet">
    <!--Modernizr js-->
    <script src="{{ url('front') }}/js/vendor/modernizr-2.8.3.min.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php

?>
<body class="<?php echo (isset($bodyClass) && $bodyClass != null)?$bodyClass:""; ?>">
<!-- Preloader -->
<div class="loader">
    <div class="status">
    </div>
</div>
<!--End of Preloader -->
<!--Header Top Area Strat-->
@include('frontlayouts.header')
<!--End of Header Top Area-->
<!--Main Menu Area Start-->
<div class="mainmenu-area">
    @include('frontlayouts.menu-header')
</div>
<!--End of Main Menu Area-->
@yield('content')
@include('frontlayouts.footer')
<!-- jQuery js-->
<script src="{{ url('front') }}/js/vendor/jquery-1.11.3.min.js"></script>
<!--Bootsrap-->
<script src="{{ url('front') }}/js/bootstrap.min.js"></script>
<!--Owl Carousel js-->
<script src="{{ url('front') }}/js/owl.carousel.min.js"></script>
<!--Meanmenu js-->
<script src="{{ url('front') }}/js/meanmenu.js"></script>
<!--Rev Slider-->
<script src="{{ url('front') }}/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="{{ url('front') }}/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="{{ url('front') }}/rs-plugin/js/jquery.themepunch.activate.js"></script>
<!--Scroll Up js-->
<script src="{{ url('front') }}/js/jquery.scrollUp.min.js"></script>
<!--Price Slider js-->
<script src="{{ url('front') }}/js/price-slider.js"></script>
<!--Countdown js-->
<script src="{{ url('front') }}/js/jquery.countdown.min.js"></script>
<!--jQuery Knob js-->
<script src="{{ url('front') }}/js/jquery.knob.js"></script>
<!--jQuery Throttle js-->
<script src="{{ url('front') }}/js/jquery.throttle.js"></script>
<!--Classi Caountdown js-->
<script src="{{ url('front') }}/js/jquery.classycountdown.js"></script>
<!-- Google Map js -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

<!--Active js-->
<script src="{{ url('front') }}/js/main.js"></script>

<!-- Intigrate AngularJs -->
<script src="{{ asset('plugins/angularjs/angular.min.js') }}"></script>
<script src="{{ asset('plugins/angularjs/angular-animate.min.js') }}"></script>
<script src="{{ asset('plugins/angularjs/angular-resource/angular-resource.min.js') }}"></script>
<script src="{{ asset('plugins/angularjs/angular-touch.min.js') }}"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-aria.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.3/angular-sanitize.js"></script>
<script src="{{ asset('plugins/angularjs/ngstorage/ngStorage.js') }}"></script>

<script src="{{ asset('angular/app.core.js') }}"></script>
<script src="{{ asset('angular/services/api.js') }}"></script>
<script src="{{ asset('angular/services/apiendpoint.js') }}"></script>
<script src="{{ asset('angular/services/apiservice.js') }}"></script>
<script type="text/javascript">
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    function setCookie(cname,cvalue,exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    
    $(document).ready(function () {
        var data = getCookie('product_details');
        var _count = 0;
        if(data != undefined && data != ""){
            var product_details = JSON.parse(data);
            _count = product_details.length;
        }
        $("#cart_count").html(_count);

    });
    var data = getCookie('product_details');
    var product_details = JSON.parse(data);
</script>

@stack('js')
</body>
</html>