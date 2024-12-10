<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href='{{asset('css/navbar.css')}}'>
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.3-dist\css\bootstrap.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Bebas+Neue&family=Oswald:wght@200..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Teko:wght@300..700&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: "Oswald", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-content"> 
                <a class="headerimg" href="{{ route('home') }}"><img
                        src="https://www.absglobaltravel.com/public/images/footer-abs-logo.webp"
                        alt="Profile Picture"></a>

                <button class="dropdown-btn">
                    My Account
                    <span class="dropdown-icon" aria-hidden="true"></span>
                </button>
                <div class="dropdown-container">
                    <a href="{{ route('Myprofile') }}">My
                        Profile</a>
                    <a
                        href="{{ route('updateprofile') }}">Update
                        Profile</a>
                    <a href="{{ route('Users') }}">Users</a>
                </div>

                <button class="dropdown-btn">
                    Blogs
                    <span class="dropdown-icon" aria-hidden="true"></span>
                </button>
                <div class="dropdown-container">
                    <a href="{{ route('Blog') }}">Blog</a>
                    <a href="{{ route('BlogCat') }}">Blog-Categories</a>
                </div>
                <button class="dropdown-btn">
                    News
                    <span class="dropdown-icon" aria-hidden="true"></span>
                </button>
                <div class="dropdown-container">
                    <a href="{{ route('Newsarticle') }}">News</a>
                    <a href="{{ route('NewsCat') }}">News-Categories</a>
                </div>
                <a href="{{ route('Pages') }}">Pages</a>
                <a href="{{ route('Company') }}">Company Profile</a>
                <a class="logout" href="{{ route('Logout') }}">Logout</a>
            </div>
        </aside>

        <div class="main-content">
            <nav class="navbar">
                <button class="menu-toggle" aria-label="Toggle menu">☰</button>
                <div class="navbar-brand"></div>
                <ul class="navbar-nav">
                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                    <li><a class="logout" href="{{ route('Logout') }}">Logout</a></li>
                </ul>
            </nav>

        <main class="content">
            @yield('content')
        </main>
    </div>
</div>
@yield('js')
<script>
   document.addEventListener('DOMContentLoaded', function() {

var dropdownBtns = document.querySelectorAll(".dropdown-btn");
dropdownBtns.forEach(function(dropdownBtn) {
    dropdownBtn.addEventListener("click", function() {
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


var menuToggle = document.querySelector('.menu-toggle');
var sidebar = document.querySelector('.sidebar');
menuToggle.addEventListener('click', function() {
    sidebar.classList.toggle('active');
});
});

</script>

<script src="/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>


    
</body>
</html>
