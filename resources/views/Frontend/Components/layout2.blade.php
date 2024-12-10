<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-qFJl9jyXm0yRB3Gr9Y+1cHiymQEZTsuRyqIBZKSzpHQePz5zN5BKnGXcfOHk7hsE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-LOt4VQSlD3xzq2mI5e1d7jO3LNN2DcEUXTM1q+TTnvgnPNwlQ4O8TZH7uj5Ip1Dj" crossorigin="anonymous"></script>

  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Teko:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('frontend') }}">
          <img src="{{ asset('img/Joshi.png') }}" alt="Logo">

        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('About') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('News') }}">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('Contact') }}">Contact</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('Blogs') }}">Blogs</a>
                </li>
                <?php if (!empty($pages)): ?>
                    <?php foreach ($pages as $page): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="Blog_website/Page/">
                                <?php echo htmlspecialchars($page['title']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="nav-item">
                        {{-- <span class="nav-link">No pages available</span> --}}
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
@yield('bread')
<main class="content2">
    @yield('content2')
</main>

<footer class="footer mt-5 py-3 bg-dark text-white">
    <div class="container text-center">
     
      <div class="row">
        <div class="col-md-4 mb-3">
          <h5>About Us</h5>
          <p>We are dedicated to providing insightful blogs and the latest news to keep you informed. Our goal is to engage, inform, and inspire our readers.</p>
        </div>
        <div class="col-md-4 mb-3">
          <h5>Quick Links</h5>
          <ul class="list-styled"> 
            <li><a href="{{ route('frontend') }}" class="text-white">Home</a></li>
            <li><a href="{{ route('Blogs') }}" class="text-white">Blogs</a></li>
            <li><a href="{{ route('About') }}" class="text-white">About</a></li>
            <li><a href="{{ route('Contact') }}" class="text-white">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-3">
          <h5>Contact Us</h5>
          <p>Email: <a href="{{ route('Contact') }}" class="text-white">sorabhjoshi11@gmail.com</a></p>
          <p>Phone: 9982541337</p>
        </div>
      </div>

    
      <div class="social-icons">
        <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
        <a href="#" class="text-white mx-2"><i class="fab fa-linkedin-in"></i></a>
      </div>

     
      <div class="mt-4">
        <p>&copy; <?= date("Y"); ?> Joshi Blogs. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

 
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  @yield('js')
</body>
</html>
<style>
  .content2
  {
    flex-direction: column
  }
    a img {
      height: 50px;
      width: auto;
    }
    
    * {
      font-family: "Teko", sans-serif;
      font-optical-sizing: auto;
      font-weight: 500;
      font-style: normal;
      font-size: 18px;
    }
    .footer .list-styled {
      list-style: none;
      padding: 0;
      margin: 0;
      text-align: center; 
    }
    .footer .list-styled li {
      margin-bottom: 0.5rem; 
    }
    .footer .list-styled a {
      text-decoration: none;
      color: white;
    }
    .footer .list-styled a:hover {
      text-decoration: underline;
    }
  </style>