<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    
    <script src="<?php echo asset('js/jquery.js');?>"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
<script src="<?php echo asset('bootstrap-iconpicker\js\jquery-menu-editor.js');?>"></script>
<script src="<?php echo asset('bootstrap-iconpicker\js\jquery-menu-editor.min.js');?>"></script>
    <!-- Fonts and Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/blog.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.3-dist/css/bootstrap.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo asset('js/jquery.js');?>"></script>
    <script src="<?php echo asset('bootstrap-iconpicker\js\jquery-menu-editor.js');?>"></script>
    <script src="<?php echo asset('bootstrap-iconpicker\js\jquery-menu-editor.min.js');?>"></script>
    <script src="<?php echo asset('js/bootstrap.js');?>"></script>
    <script src="<?php echo asset('js/menu.js');?>"></script>
    <script src="<?php echo asset('js/popper.js');?>"></script>
    <script src="<?php echo asset('js/perfect-scrollbar.js');?>"></script>
    <script src="<?php echo asset('js/apexcharts.js');?>"></script>
    <script src="<?php echo asset('js/perfect-scrollbar.js');?>"></script>
    <script src="<?php echo asset('js/config.js');?>"></script>
    <script src="<?php echo asset('js/menu.js');?>"></script>
    <script src="<?php echo asset('js/dashboards-analytics.js');?>"></script>
    <script src="<?php echo asset('js/helpers.js');?>"></script>
    <script src="<?php echo asset('js/main.js');?>"></script>
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="<?php echo asset('bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js'); ?>"></script>
    <script src="<?php echo asset('bootstrap-iconpicker/js/bootstrap-iconpicker.min.js');?>"></script>
    <script src="<?php echo asset('bootstrap-iconpicker/js/jquery-menu-editor.min.js');?>"></script>
    <script src="/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js"></script>
    <script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js"></script>
    <script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/jquery-menu-editor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+6pDI6b9j7/DA5Ctae/DiDF6z8crwJh7t2KUnUU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
body, html {
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
    height: 100vh;
    color: #333;
    background-color: #f4f4f4;
    overflow-y: scroll;
}
#myEditor li{
    padding: 10px !important;
    
}
#myEditor{
    margin: auto;
}
.card{
    width: 400px !important;
    margin: auto;
}
.container {
    width: 98% !important;
    
}
.output-section{
    width: 700px !important;
    margin: auto;
}
/* .img {
width: 250px;
box-sizing: border-box;
overflow: hidden;
padding: 10px;
border-bottom: 1px solid #4b5c70;
}
.img img{
    width: 222px;
    cursor: pointer;

} */
/* Header Image */
.headerimg {
    align-items: center;
    color: white;
    text-decoration: none;
    cursor: pointer;
    text-align: center;
    transition: none;
    border: none;
}
.dropdown-item:hover {
    background-color: #ba3b31 !important;
    color: rgb(0, 0, 0) !important;
    
}
.headerimg:hover {
    background-color: none !important;
    transform: none !important;
    box-shadow: none !important;
}

.headerimg img {
    width: 150px;
    height: 28px;
    margin: auto;
}

/* Dashboard Container */
.dashboard-container {
    display: flex;
    height: 100%;
}

/* Sidebar Styles */
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
    box-shadow: 4px 0 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    overflow-y: auto; 
}

.sidebar-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    padding: 0 20px;
}


.menu {
    list-style-type: none;
    padding: 0;
}

.menu-item {
    list-style: none;
}

.menu-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
    padding: 10px;
    text-decoration: none;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.3s ease;
    border-bottom: 1px solid #4b5c70;
}

.menu-link:hover {
    background-color: #4b5c70;
    transform: translateX(5px);
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
}

.menu-item.active .dropdown-icon {
    transform: rotate(180deg);
}

.menu-sub {
    display: none;
    background-color: #3a4b60;
    padding-left: 16px;
}

.menu-item.active > .menu-sub {
    display: block;
}

.menu-sub .menu-item {
    transition: background-color 0.3s ease;
}

.menu-sub .menu-item:hover {
    background-color: #4b5c70;
}

.dropdown-icon {
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid white;
    display: inline-block;
    transition: transform 0.3s ease;
}

/* Main Content */
.main-content {
    margin-left: 250px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    min-height: 120vh;
}

.content {
    padding: 0 20px 0 20px;
    height: 100%;
    flex-grow: 1;
}

.overview-section {
    padding: 20px;
}

/* Navbar */
.navbar {
    background-color: #ffffff;
    /* padding: 10px 20px; */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-nav {
    display: flex;
    list-style-type: none;
    /* padding: 0; */
}

.navbar-nav li {
    margin-left: 20px;
}

.navbar-nav a {
    text-decoration: none;
    color: #333;
    /* padding: 10px 15px; */
    border-radius: 4px;
    transition: background-color 0.3s;
}

.navbar-nav a:hover {
    background-color: #e9ecef;
}

.logout {
    border: none !important;
}

.logout:hover {
    background-color: #b84b4b !important;
    color: white;
}

/* Responsive Sidebar */
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

/* Additional Sidebar Styles */
.dropdown-btn.active + .dropdown-container {
    display: block;
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

.dropdown-btn {
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

.dropdown-btn.active {
    background-color: #1c2a38;
}
.popover{
    display: flex; 
    justify-content: flex-end; 
    align-items: flex-end; 
}
::-webkit-scrollbar {
  width: 0px;
}

::-webkit-scrollbar-track {
  background-color: transparent;
}

::-webkit-scrollbar-thumb {
  background-color: #d6dee1;
  border-radius: 20px;
  border: 6px solid transparent;
  background-clip: content-box;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #a8bbbf;
}
    </style>
    
   
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        @include('Blogbackend.components.sidebar')
        

        <div class="main-content">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-0">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto m-0 p-2"> 
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
    
</body>
<script>
    // Toggle the dropdown menu
    document.querySelectorAll('.menu-toggle').forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            let parentMenuItem = toggle.closest('.menu-item');
            parentMenuItem.classList.toggle('active');
        });
    });
</script>
</html>