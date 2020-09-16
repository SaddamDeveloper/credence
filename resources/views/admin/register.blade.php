<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ciel Couture | Admin Register</title>

    <link href="{{ asset('admin_employee/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_employee/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_employee/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_employee/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_employee/css/style.css') }}" rel="stylesheet">

    <!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo/logo.png') }}">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">Ciel Couture</h1>

            </div>
            <h3>Register to Ciel Couture Admin</h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" action="{{ url('/register/admin') }}" autocomplete="off" method="POST">
                @csrf
                <div class="form-group">
                <input type="text" class="form-control" placeholder="Name" value="{{ old('name') }}" name="name" required="">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" name="email" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="">
                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>
                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('admin.login') }}">Login</a>
            </form>
            <p class="m-t"> <small>Developed by Softzoned Team</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('admin_employee/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('admin_employee/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin_employee/js/bootstrap.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('admin_employee/js/plugins/iCheck/icheck.min.js') }}"></script>
</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.2/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Jul 2019 18:08:43 GMT -->
</html>
