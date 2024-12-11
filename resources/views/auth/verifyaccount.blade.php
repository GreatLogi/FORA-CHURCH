<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <title>Changed Password | {{ config('app.name') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('android/mipmap-hdpi/ic_launcher.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/material.css') }}">
    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
</head>

<body class="account-page">
    <!-- Main Wrapper -->

    <div class="main-wrapper">
        <div class="account-content">
            <!-- Account Logo -->
            {{-- <div class="account-logo">
                <a href="admin-dashboard.html"><img src="assets/img/logo2.png" alt="Dreamguy's Technologies"></a>
            </div> --}}
            <div class="account-logo">
                <a href="admin-dashboard.html"><img src="{{ asset('android/mipmap-xxhdpi/ic_launcher.png') }}"
                        alt="Dreamguy's Technologies"></a>
            </div>
            <div class="account-box">

                <div class="account-wrapper">
                    <h3 class="account-title">Change Password</h3>
                    @if (session('expired'))
                        <h5 class="text-danger my-4"><b class="text-danger">Password has expired. Please create a new
                                password.</b></h5>
                    @elseif(session('first_login'))
                        <h5 class="text-muted my-4"><b class="text-danger">Please change your default password.</b></h5>
                    @else
                        <h5 class="text-muted my-4"><b class="text-danger">Please change your password to get access to
                                the portal.</b></h5>
                    @endif
                    <form method="POST" action="{{ route('changed-password') }}">
                        @csrf
                        <div class="input-block mb-3">
                            <label class="col-form-label">New password</label>
                            <input type="password" name="password" required class="form-control">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Confirm password</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation" required>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="submit-section mb-4">
                            <button class="btn btn-primary submit-btn">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
