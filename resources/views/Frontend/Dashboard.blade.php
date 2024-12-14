@extends('Frontend.Components.layout2')

@section('title', 'Dashboard')

@section('content2')
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<main>
  <div class="container text-center my-5 img-container">
    <h1 class="mb-3">Welcome to Our Website!</h1>
    <p class="lead">Explore our latest blogs and stay updated with the latest news.</p>
    <div>
      <a href="{{ url('Blogs') }}" class="btn btn-primary m-2">Our Blogs</a>
      <a href="{{ url('News') }}" class="btn btn-secondary m-2">News</a>
    </div>
  </div>

  <div class="bread bg-gray">
    <h2 class="text-left">Blog</h2>
  </div>

  <div class="container my-3">
    <div class="row g-4">

      
      <div class="col-md-9">
        <div>
          <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($users->take(3) as $user)
              <div class="col">
                <div class="card h-100 card-custom">
                  <img src="{{ asset($user->image) }}" class="card-img-top" alt="{{ $user->Title }}">
                  <div class="card-body">
                    <a href="{{ url('Blog/' . $user->slug) }}" class="text-decoration-none text-dark">
                      <h5 class="card-title">{{ $user->title }}</h5>
                      <p class="card-text">
                        {{ Str::limit(strip_tags($user->description), 100) }}...
                      </p>
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

      
        <div>
          <h2 class="text-center m-4 p-2" style="border-bottom: 2px solid purple;" id="news">Latest News</h2>
          <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($news->take(3) as $new)
              <div class="col">
                <div class="card h-100 card-custom">
                  <img src="{{ asset( $new->image) }}" class="card-img-top" alt="{{ $new->title }}">
                  <div class="card-body">
                    <a href="{{ url('News/' . $new->slug) }}" class="text-decoration-none text-dark">
                      <h5 class="card-title">{{ $new->title }}</h5>
                      <p class="card-text">
                        {{ Str::limit(strip_tags($new->description), 100) }}...
                      </p>
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Right Details Bar Column (25%) -->
      <div class="col-md-3">
        <img class="img" src="https://colorlib.com/wp/wp-content/uploads/sites/2/colorlib-custom-web-design.png.avif" alt="">
        <div class="socialtags">
          <h4>Follow Us</h4>
          <ul class="list-unstyled">
            <li><a href="#" ><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="#" ><i class="fab fa-twitter"></i></a></li>
            <li><a href="#" ><i class="fab fa-instagram"></i></a></li>
            <li><a href="#" ><i class="fab fa-linkedin-in"></i></a></li>
            <li><a href="#" ><i class="fab fa-youtube"></i></a></li>
          </ul>
          <ul class="list">
            @foreach ($news->take(4) as $new)
              <li class="li-container">
                <img src="{{ asset( $new->image) }}" class="card-img-top">
                <a href="{{ url('News/' . $new->slug) }}" class="text-decoration-none text-dark">
                  <h5 class="card-title">{{ $new->title }}</h5>
                </a>
              </li>
            @endforeach
            @foreach ($users->take(4) as $user)
              <li class="li-container">
                <img src="{{ asset( $user->image) }}" class="card-img-top">
                <a href="{{ url('Blog/' . $user->slug) }}">
                  <h5 class="card-title">{{ $user->title }}</h5>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>

    </div>
  </div>

</main>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<style>
 .list{
  width: 100%;
  margin-left: 0;
  padding-left: 0;
  align-items: start;
 }
.li-container {
  display: flex;
  
  align-items: center;  
  text-align: left;
  width: 100%;
  border-top: .5px solid #e9e5e5;
  padding-top: 10px;
}

.li-container img {
  height: 50px;  
  width: 50px;   
  object-fit: cover;  
  border-radius: 5px; 
  margin-right: 10px;  
}


.li-container h5 {
  font-size: 1rem;
  margin: 0;
  color: #333;
}
.card-title:hover{
  color: #52adbf;
}
  
  ul li {
    margin: 10px 0;
  }
  .socialtags {
    padding: 20px 0 20px;
  }
  .list-unstyled {
    display: flex;
    flex-direction: row;
  }
  ul li a {
    font-size: 1.25rem;
    color: #333;
    text-decoration: none;
    align-items: center;
  }
  ul li a:hover {
    color: #52adbf;
  }
  ul li a i {
    margin-right: 10px;
  }

  /* Main image container styling */
  .img-container {
    position: relative;
<<<<<<< HEAD
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/default.jpg');
=======
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/photo-1503694978374-8a2fa686963a.avif');
>>>>>>> 021908dff41cbfdfe4823b97e24c1226c69e77f2
    background-size: cover;
    background-position: center;
    padding: 70px 20px;
    margin: 0 !important;
    max-width: 100%;
    color: #f9f9f9;
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.6);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  
  .bread {
    background-color: #e1e1e1;
  }
  .img {
    height: 280px;
    width: 100%;
    margin: 0 auto 0 auto;
  }
  /* Styling for the welcome heading */
  .img-container h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #fff;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
  }

  /* Buttons in the welcome section */
  .img-container .btn {
    padding: 10px 20px;
    border-radius: 50px;
    font-size: 1rem;
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
    border: 1px solid #f9f9f9;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
  }

  .img-container .btn:hover {
    background-color: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.5);
  }

  /* Enhanced Card styling */
  .card-custom {
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    overflow: hidden;
  }

  .card-custom:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
  }

  /* Blog and News images */
  .card-img-top {
    object-fit: cover;
    height: 200px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    transition: transform 0.3s ease;
  }

  .card-img-top:hover {
    transform: scale(1.1);
  }

  /* Card body text */
  .card-body h5 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
  }

  .card-body p {
    font-size: 0.9rem;
    color: #555;
    line-height: 1.5;
  }

  /* Section Headings */
  .text-left {
    text-align: left;
  }

  .lead {
    font-size: 1.3rem;
  }

  /* Additional Styles */
  .bread {
    background-color: #e1e1e1;
    padding: 20px 20px 20px 70px ;
  }
  .card-body h5:hover {
        color: #52adbf;
        transition: all 0.3s ease;
    }

    .card-body p:hover {
        color: #52adbf;
        transition: all 0.3s ease;
    }

  
</style>
@endsection

