<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ashia 2020 – Wear The Strom</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('web/images/favicon.png')}}">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{asset('web/css/custom.css')}}">
    <style>.order-nav ul li.navi{border-color: transparent;}</style>
    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="{{asset('web/css/vendor/vendor.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/plugins/plugins.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/style.min.css')}}">

</head>

<body>

    <div class="coming-soon-section section section-padding" data-bg-image="{{asset('web/images/bg/coming-soon-bg.jpg')}}">
        <div class="container">
            <div class="coming-soon-content text-lg-left">
                <div class="logo">
                    <a href="index.html"><img src="{{asset('web/images/logo/logo-2.png')}}" alt=""></a>
                </div>
                <div class="order-nav mb-4">
                    <ul style="justify-content: left;margin-left: -94px;">
                        <li class="navi d"><i class="ti-check"></i>Cart</li>
                        <li>></li>
                        <li class="navi d"><i class="ti-check"></i>Login</li>
                        <li>></li>
                        <li class="navi d"><i class="ti-check"></i>Checkout</li>
                        <li>></li>
                        <li class="navi current">Order Placed</li>
                    </ul>
                </div>
                <h2 class="title">Order Placed</h2>
                <h4 style="margin-bottom: 40px;">Your order is successful placed</h4>
                <div class="coming-soon-subscribe">
                    <a href="{{route('web.order_history')}}" class="btn btn-sm btn-outline-dark">My orders</a>
                    <a href="{{route('web.index')}}" class="btn btn-sm btn-primary">Go To Homepage</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JS ============================================ -->
    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="{{asset('web/js/vendor/vendor.min.js')}}"></script>
    <script src="{{asset('web/js/plugins/plugins.min.js')}}"></script>

    <!-- Main Activation JS -->
    <script src="{{asset('web/js/main.js')}}"></script>

</body>

</html>