





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.3-dist/css/bootstrap.css') }}">

    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            /* height: 100vh; */
            margin: 0;
            padding: 0;
        }

        .card {
            border: none;
            border-radius: 8px;
            margin: 20px;
            /* width:60vw; */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #1e3a8a;
            color: #fff;
            font-weight: 600;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            text-align: center;
            padding: 20px;
        }

        .card-body {
            padding: 30px;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 15px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #1e3a8a;
            box-shadow: 0px 0px 5px rgba(30, 58, 138, 0.2);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #555;
        }

        .btn-primary {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
            padding: 12px 20px;
            border-radius: 5px;
            /* width: 100%; */
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            background-color: #1c2d5a;
            border-color: #1c2d5a;
        }
        .col-md-8 {
        flex: 0 0 auto;
        width: 50%;
    }
        .btn-link {
            color: #1e3a8a;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .invalid-feedback {
            display: block;
            color: #e74c3c;
            font-size: 0.9rem;
        }
        
        .navbar {
            background-color: #ffffff;
            /* padding: 10px 20px; */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: end;
            align-items: center;
            width: 100vw
        }

        .navbar-nav {
            display: flex;
            list-style-type: none;
            /* margin: 10px; */
            padding: 0;
        }

        .navbar-nav li {
            margin-left: 20px;
        }

        .navbar-nav a {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .navbar-nav a:hover {
            background-color: #e9ecef;
        }

        .content {
            padding: 0 20px 0 20px;
            flex-grow: 1;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
        }

        
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
   
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
    
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
    
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
    
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
























