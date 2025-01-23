<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel')</title>
    
    <script src="<?php echo asset('js/jquery.js');?>"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Fonts and Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    
   
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
        // Dropdown Menu Toggle
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

        // Sidebar Toggle
        const toggleBtn = document.querySelector('.toggle-btn');
        const sidebar = document.getElementById("mySidebar");
        const mainContent = document.querySelector(".main-content");

        if (toggleBtn && sidebar && mainContent) {
            toggleBtn.addEventListener('click', function () {
                let currentWidth = sidebar.style.width;
                if (currentWidth === '300px' || currentWidth === '') {
                    sidebar.style.width = '65px';
                    mainContent.style.marginLeft = '65px';
                } else {
                    sidebar.style.width = '300px';
                    mainContent.style.marginLeft = '300px';
                }
            });

            // Adjust sidebar based on screen width
            window.addEventListener('resize', function () {
                let screenWidth = window.innerWidth;
                if (screenWidth < 768) {
                    sidebar.style.width = '65px';
                    mainContent.style.marginLeft = '65px';
                } else {
                    sidebar.style.width = '300px';
                    mainContent.style.marginLeft = '300px';
                }
            });
        }

        // Navbar Dropdown Toggle
        var navbarToggles = document.querySelectorAll('.menu-toggle');
        navbarToggles.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                let parentMenuItem = toggle.closest('.menu-item');
                parentMenuItem.classList.toggle('active');
            });
        });

        // Screen width adjustment for header images
        $(document).ready(function () {
            let screenWidth = $(window).width();

            if (screenWidth < 768) {
                $('.imghead').hide();
                $('.headerimg').css('padding', '7px 8px');
            }

            $(window).resize(function () {
                screenWidth = $(window).width();

                if (screenWidth < 768) {
                    $('.imghead').hide();
                    $('.headerimg').css('padding', '7px 8px');
                } else {
                    $('.imghead').show();
                    $('.headerimg').css('padding', '0');
                }
            });
            $('.toggle-btn').click(function () {
                let width = $('#mySidebar').css('width');
    
                if (width === '300px') {
                    $('#mySidebar').css('width', '65px');
                    $('.menu').css('padding-left', '0');
                    $('.menu-toggle').css('padding', '15px 16px');
                    $('.menu-toggle-icon').hide().prev('div').hide();
                    $('.menu-item:last').find('div').hide();
                    $('.active').find('.menu-sub').hide();
                    $('.main-content').css('margin-left', '65px');
                    $('.sidebar-content').css('padding', '0 9px');
                    $('.imghead').hide();
                    $('.toggle-btn').css('margin', '6px');
                } else if (width === '65px') {
                    $('#mySidebar').css('width', '300px');
                    $('.menu').css('padding-left', '0rem');
                    $('.menu-toggle').css('padding', '15px 16px');
                    $('.menu-toggle-icon').show().prev('div').show();
                    $('.menu-item:last').find('div').show();
                    $('.active').find('.menu-sub').show();
                    $('.main-content').css('margin-left', '300px');
                    $('.sidebar-content').css('padding', '0 9px');
                    $('.imghead').css('display', 'flex');
                    $('.toggle-btn').css('margin', '0px');
                    $('.headerimg').css('padding', '0');
                }
            });
        });

        // Activate menu-item when clicked
        $('.menu-item').on('click', function () {
            let sidebarWidth = parseFloat($('.sidebar-content').css('width'));

            if (sidebarWidth <= 280) {
                sidebar.style.width = '300px';
                mainContent.style.marginLeft = '300px';
                $('.imghead').css('display', 'flex');
            }
        });
    });
</script>

    
</body>


</html>