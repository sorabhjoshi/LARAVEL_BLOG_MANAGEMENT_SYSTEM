@extends('Frontend.Components.layout2')

@section('title', 'News')

@section('bread')
<div class="bread">
  <h3 style="text-self:right;">News Design</h3> 
  <p><a href="Blog_website/NewsArticles">Home</a> >> <a href="Blog_website/NewsArticles">News</a> >>  <a href="#">{{$news['title']}}</a></p>
    
  </div>
@endsection


@section('content2')

<main>
    <div class="allcontainer">
        <div class="text-center">
            @if (!empty($news['image']))
                <img src="{{ asset($news['image']) }}" class="blog-image mb-4" alt="{{ $news['title'] }}">
            @else
                <img src="{{ asset('default-image.jpg') }}" class="blog-image mb-4" alt="No Image Available">
            @endif
        </div>
        <div class="container my-5">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="text-left mb-4">{{ $news['title'] }}</h1>
                    <div class="blog-details">
                        <p><strong>Author:</strong> {{ $news['authorname'] }}</p>
                        <p><strong>Published on:</strong> {{ \Carbon\Carbon::parse($news['created_at'])->format('F j, Y') }}</p>
                    </div>
                    <div class="blog-content mb-4">
                        <p class="drop-cap">{!! $news['description'] !!}</p>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('News') }}" class="btn-back mt-4">Back to News</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <img class="img" src="https://colorlib.com/wp/wp-content/uploads/sites/2/colorlib-custom-web-design.png.avif" alt="">
                    <div class="socialtags">
                        <h4>Follow Us</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" aria-label="Follow us on Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" aria-label="Follow us on Twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" aria-label="Follow us on Instagram"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" aria-label="Follow us on LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#" aria-label="Follow us on YouTube"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                        <ul class="list">
                          @foreach ($tags as $item)
                          <li class="li-container">
                              <img src="{{ asset($item['image'] ?? 'default-image.jpg') }}" loading="lazy" class="card-img-top" alt="{{ $item['title'] }}">
                              <a href="{{ url('News/' . $item['slug']) }}" class="text-decoration-none text-dark">
                                  <h5 class="card-title">{{ $item['title'] }}</h5>
                              </a>
                          </li>
                      @endforeach
                      
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

<style>
    .bread a {
    color: black; 
    text-decoration: none; 
    font-weight: 600; 
    transition: color 0.3s ease; 
  }
  
  .bread a:hover {
    color:#282aa7;
  }
    ul li a {
      font-size: 1.25rem;
      color: #333;
      text-decoration: none;
      margin-right: 10px;
    }
    
    ul li a:hover {
      color: #52adbf;
    }
  
    ul li a i {
      margin-right: 10px;
    }
    .li-container {
      display: flex;
      align-items: center;
      text-align: center;
      width: 100%;
      border-top: 0.5px solid #e9e5e5;
      padding: 10px 0 10px 0;
    }
    .card-title:hover{
    color: #52adbf;
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
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
  
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f3f4f6;
      color: #333;
      line-height: 1.7;
    }
  
    main {
      display: flex;
      justify-content: center;
      align-items: center;
      background: #ffffff;
    }
  
    h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 25px;
      text-transform: capitalize;
    }
  
    .allcontainer {
      width: 90%;
    }
  
    .blog-image {
      width: 90%;
      margin-top: 40px;
      height: auto;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      object-fit: cover;
    }
  
    .blog-details {
      font-size: 1rem;
      color: #475569;
      border-left: 3px solid #4f46e5;
      padding-left: 10px;
      margin-top: 25px;
    }
  
    .blog-details strong {
      color: #1e293b;
    }
  
    .blog-content {
      font-size: 1.15rem;
      color: #374151;
      line-height: 1.8;
      margin-top: 30px;
      text-align: justify;
      font-weight: 300;
    }
  
    .drop-cap::first-letter {
      font-size: 3rem;
      font-weight: 700;
      color: #4f46e5;
      float: left;
      line-height: 1;
      margin-right: 10px;
    }
  
    .btn-back {
      display: inline-block;
      padding: 10px 30px;
      background-color: #6366f1;
      color: white;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 25px;
      text-decoration: none;
      transition: background-color 0.3s ease, transform 0.3s ease;
      margin-top: 30px;
    }
  
    .btn-back:hover {
      background-color: #4f46e5;
      transform: translateY(-2px);
    }
  
    .img {
      height: 280px;
      width: 100%;
      margin: 0 auto;
    }
  
    .socialtags {
      padding: 20px 0;
    }
  
    .list-unstyled {
      display: flex;
      flex-direction: row;
      margin-bottom: 20px;
    }
  
    ul li a {
      font-size: 1.25rem;
      color: #333;
      text-decoration: none;
      margin-right: 10px;
    }
  
    ul li a:hover {
      color: #52adbf;
    }
     ul{
      padding-left: 0;
    }
    .bread {
    width: 100%;
    background-color: #eeeeee;
    padding: 15px 120px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
  }
  
  .bread h3 {
    margin: 0;
    text-align: left;
  }
  
  .bread p {
    margin: 0;
    text-align: right;
  }
  
  </style>