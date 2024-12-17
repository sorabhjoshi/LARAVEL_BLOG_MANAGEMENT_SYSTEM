<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>

    <!-- Fonts and Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.3-dist/css/bootstrap.css') }}">

    <style>
        .headerimg {
            align-items: center;
            color: white;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
            transition: none;
            border: none;
        }

        .headerimg:hover {
            background-color: none !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .headerimg img {
            width: 150px;
            height: 30px;
            margin: auto;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            color: #333;
            background-color: #f4f4f4;
        }
        .container{
            width: 98% !important;
        }
        .dashboard-container {
            display: flex;
            height: 100%;
        }

        .sidebar {
            width: 250px;
            background-color: #2d3e50;
            color: white;
            height: 100%;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease-in-out;
            box-shadow: 4px 0 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            padding: 0 20px;
        }

        .dropdown-container {
            display: none;
            transition: all 0.3s ease;
        }

        .dropdown-btn.active + .dropdown-container {
            display: block;
        }

        .sidebar a, .sidebar .dropdown-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            padding: 16px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background-color: transparent;
            text-align: left;
            font-size: 16px;
            transition: all 0.3s ease;
            border-bottom: 1px solid #4b5c70;
        }

        .sidebar a:hover, .sidebar .dropdown-btn:hover {
            background-color: #4b5c70;
            transform: translateX(5px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
        }

        .sidebar a.active, .sidebar .dropdown-btn.active {
            background-color: #1c2a38;
        }

        .dropdown-container {
            display: none;
            background-color: #3a4b60;
            padding-left: 8px;
            margin: 5px;
        }

        .dropdown-container a {
            padding: 12px 16px 12px 24px;
            transition: background-color 0.3s ease;
        }

        .dropdown-container a:hover {
            background-color: #4b5c70;
        }

        .dropdown-icon {
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid white;
            display: inline-block;
            margin-left: 5px;
            transition: transform 0.3s;
        }

        .dropdown-btn.active .dropdown-icon {
            transform: rotate(180deg);
        }

        .main-content {
            margin-left: 250px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 120vh;
        }

        .navbar {
            background-color: #ffffff;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            height: 100%;
            flex-grow: 1;
        }
        .overview-section{
            padding: 20px;
        }
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }
        }

        .logout:hover {
            background-color: #b84b4b !important;
            color: white;
        }

        .logout {
            border: none !important;
        }

        .navbar-nav {
            display: flex !important;
            flex-direction: row !important;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-content">
                <a class="headerimg" href="{{ route('home') }}">
                    <img src="https://www.absglobaltravel.com/public/images/footer-abs-logo.webp" alt="Profile Picture">
                </a>

                <button class="dropdown-btn">
                    My Account
                    <span class="dropdown-icon" aria-hidden="true"></span>
                </button>
                <div class="dropdown-container">
                    <a class="nav-link" href="{{ route('Myprofile') }}">My Profile</a>
                    @auth
                    @if(auth()->user()->hasRole('Admin'))
                    {{-- <a href="{{ route('updateprofile') }}">Update Profile</a> --}}
                    <a class="nav-link" href="{{ route('users.index') }}">Manage Users</a>
                    <a class="nav-link" href="{{ route('roles.index') }}">Manage Role</a>
                    @endif
                    @endauth
                </div>
                @if(auth()->user()->hasRole(['Blogs-team','Admin']))


                <button class="dropdown-btn">
                    Blogs
                    <span class="dropdown-icon" aria-hidden="true"></span>
                </button>
                <div class="dropdown-container">
                    <a href="{{ route('Blog') }}">Blog</a>
                    <a href="{{ route('BlogCat') }}">Blog-Categories</a>
                </div>
                
                @endif
                @if(auth()->user()->hasRole(['News-team','Admin']))
                <button class="dropdown-btn">
                    News
                    <span class="dropdown-icon" aria-hidden="true"></span>
                </button>
                <div class="dropdown-container">
                    <a href="{{ route('Newsarticle') }}">News</a>
                    <a href="{{ route('NewsCat') }}">News-Categories</a>
                </div>
                @endif
                <a href="{{ route('Modules') }}">Modules</a>
                <a href="{{ route('Pages') }}">Pages</a>
                <a href="{{ route('Company') }}">Company Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
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
                            @else
                                <li><a class="nav-link" href="{{ route('home') }}">Dashboard</a></li>
                    
                                {{-- <li><a class="nav-link" href="{{ route('products.index') }}">Manage Product</a></li> --}}
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>
    @yield('js')
    <script>
        function toggleNavbar() {
            const navbar = document.querySelector('.navbar-nav');
            navbar.classList.toggle('active');
        }
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dropdown functionality
            var dropdownBtns = document.querySelectorAll(".dropdown-btn");
            dropdownBtns.forEach(function (dropdownBtn) {
                dropdownBtn.addEventListener("click", function () {
                    this.classList.toggle("active");
                    var dropdownContent = this.nextElementSibling;
                    if (dropdownContent.style.display === "block") {
                        dropdownContent.style.display = "none";
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        dropdownContent.style.display = "block";
                        this.setAttribute('aria-expanded', 'true');
                    }
                });
            });

            // Sidebar toggle functionality
            var menuToggle = document.querySelector('.menu-toggle');
            var sidebar = document.querySelector('.sidebar');
            menuToggle.addEventListener('click', function () {
                sidebar.classList.toggle('active');
            });
        });
    </script>

    <script src="/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
