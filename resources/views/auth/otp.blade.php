<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <title>OTP | {{ config('app.name') }}</title>
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

    <style>
        .main-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Full viewport height */
            padding: 20px;
            /* Add padding to prevent tight edges */
            background-color: #f9f9f9;
            /* Optional: Add a light background */
        }

        .account-content {
            width: 100%;
            max-width: 600px;
            /* Increase the width to allow space for OTP inputs */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .account-box {
            width: 100%;
            padding: 20px;
            background: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .otp-wrap {
            display: flex;
            justify-content: center;
            gap: 10px;
            /* Spacing between inputs */
            margin: 20px 0;
            flex-wrap: wrap;
            /* Allow wrapping on smaller screens */
        }

        .otp-input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .otp-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 3px rgba(0, 123, 255, 0.5);
        }

        .account-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .account-subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .input-block {
            margin-top: 15px;
        }

        .account-btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">OTP</h3>
                    <p class="account-subtitle">Verify your account</p>

                    <!-- Account Form -->
                    <form method="POST" action="{{ route('otp.verify') }}">
                        @csrf
                        <div class="otp-wrap">
                            <input type="text" placeholder="0" maxlength="1" class="otp-input"
                                oninput="moveToNext(this, 'otp-input-2')" id="otp-input-1">
                            <input type="text" placeholder="0" maxlength="1" class="otp-input"
                                oninput="moveToNext(this, 'otp-input-3')" id="otp-input-2">
                            <input type="text" placeholder="0" maxlength="1" class="otp-input"
                                oninput="moveToNext(this, 'otp-input-4')" id="otp-input-3">
                            <input type="text" placeholder="0" maxlength="1" class="otp-input"
                                oninput="moveToNext(this, 'otp-input-5')" id="otp-input-4">
                            <input type="text" placeholder="0" maxlength="1" class="otp-input"
                                oninput="moveToNext(this, 'otp-input-6')" id="otp-input-5">
                            <input type="text" placeholder="0" maxlength="1" class="otp-input"
                                oninput="combineOtp()" id="otp-input-6">
                        </div>

                        <input type="hidden" name="otp_code" id="otp_code">
                        <div class="input-block mb-3">
                            <button class="btn btn-primary account-btn" type="submit">Enter</button>
                        </div>
                    </form>

                    <!-- Resend OTP Form -->
                    <form method="POST" action="{{ route('otp.resend') }}" id="resend-otp-form">
                        @csrf
                        <div class="account-footer">
                            <p>Not yet received?
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Resend OTP</button>
                            </p>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <script>
        function moveToNext(currentInput, nextInputId) {
            const maxLength = currentInput.getAttribute("maxlength");
            if (currentInput.value.length === maxLength) {
                document.getElementById(nextInputId).focus();
            }
        }

        function combineOtp() {
            const inputs = document.querySelectorAll('.otp-input');
            const otpCode = Array.from(inputs).map(input => input.value).join('');
            document.getElementById('otp_code').value = otpCode;
        }
    </script>
    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
