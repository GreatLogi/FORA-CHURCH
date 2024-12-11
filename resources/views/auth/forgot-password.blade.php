<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <title>FORGOT-PASSWORD | {{ config('app.name') }}</title>
    <!-- Favicon -->
    {{-- <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png"> --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('android/mipmap-hdpi/ic_launcher.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/material.css') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body class="account-page">
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container">
                <!-- Account Logo -->
                {{-- <div class="account-logo">
                    <a href="admin-dashboard.html"><img src="assets/img/logo2.png" alt="Dreamguy's Technologies"></a>
                </div> --}}
                <div class="account-logo">
                    <a href="admin-dashboard.html"><img src="{{ asset('android/mipmap-xxhdpi/ic_launcher.png') }}"
                            alt="Dreamguy's Technologies"></a>
                </div>
                <!-- /Account Logo -->
                <div class="account-box">
                    <div class="account-wrapper">
                        <p class="account-subtitle">Access to our dashboard</p>
                        <!-- Account Form -->
                        <form method="POST" action="{{ route('forgot-password-reset') }}">
                            @csrf
                            <div class="input-block mb-4">
                                <label class="col-form-label">Email<span class="mandatory">*</span></label>
                                <input class="form-control" type="text" name="email">
                            </div>
                            <div class="input-block mb-4">
                                <label class="col-form-label">Password<span class="mandatory">*</span></label>
                                <input class="form-control" type="password" name="password">
                            </div>
                            <div class="input-block mb-4">
                                <label class="col-form-label">Repeat Password<span class="mandatory">*</span></label>
                                <input class="form-control" type="password" name="password_confirmation"
                                    id="password_confirmation">
                            </div>
                            <div class="input-block mb-4 text-center">
                                <button class="btn btn-primary account-btn" type="submit">Register</button>
                            </div>
                        </form>
                        <!-- /Account Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
