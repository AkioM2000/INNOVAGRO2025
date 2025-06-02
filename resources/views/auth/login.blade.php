<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Sistem Management Arsip</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,500,600,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f4f6f9;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Source Sans Pro', sans-serif;
    }

    .login-box {
        width: 380px;
        margin: 0 auto;
    }

    .card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }

    .login-logo {
        text-align: center;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .login-logo img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #45977a;
        padding: 2px;
    }

    .login-logo span {
        font-size: 20px;
        font-weight: 600;
        color: #333;
    }

    .login-title {
        text-align: center;
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin-bottom: 35px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #45977a;
        border-radius: 10px;
        font-size: 15px;
        color: #333;
        background: #fff;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #367c64;
    }

    .form-control::placeholder {
        color: #999;
    }

    .btn-login {
        width: 150px;
        padding: 12px;
        background: #45977a;
        border: none;
        border-radius: 25px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        display: block;
        margin: 30px auto 0;
    }

    .btn-login:hover {
        background: #367c64;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .remember-me {
        display: none;
    }

    .forgot-password {
        display: none;
    }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="card">
            <div class="login-logo">
                <img src="{{ asset('img/logo.png') }}" alt="eSima Logo">
                <span>Sistem Management Arsip</span>
            </div>

            <h1 class="login-title">Login</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="Email" required autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
</body>

</html>