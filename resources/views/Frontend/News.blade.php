@extends('Frontend.Components.layout2')

@section('title', 'News')

@section('bread')
<div class="bread">
  <h3 style="text-self:right;">News Design</h3> <p><a href="{{ route('frontend') }}">Home</a> >> <a href="#">News Design</a></p>
  </div>
@endsection

@section('content2')

<main>
    <div class="container my-3">
        <h2 class="text-center mb-4" id="news">Latest News</h2>

        <div class="row">
            <!-- News Section -->
            <div class="col-md-9">
                <div class="row row-cols-1 row-cols-md-3 g-4" id="news-container">
                    @foreach ($news as $index => $new)
                        <div class="col featured" @if($index >= 3) style="display: none;" @endif>
                            <div class="card h-100 card-custom">
                                <img src="{{ asset( $new['image']) }}" class="card-img-top" alt="{{ $new['title'] }}">
                                <div class="card-body">
                                    <a href="{{ url('News/' . $new['slug']) }}" class="text-decoration-none text-dark">
                                        <h5 class="card-title">{{ $new['title'] }}</h5>
                                        <p class="card-text">
                                            {{ Str::limit(strip_tags($new['description']), 100, '...') }}
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <button id="load-more" class="btn btn-primary">Load More</button>
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="col-md-3">
                <ul class="cats">
                    <h4>Categories</h4>
                    @foreach ($category as $tag)
                        <li>
                            <a href="{{ url('News/Category/' . $tag['categorytitle']) }}">
                                {{ htmlspecialchars($tag['categorytitle']) }}-({{$tag->news_count}})
                            </a>
                        </li>
                    @endforeach
                </ul>
                <img class="img" src="https://colorlib.com/wp/wp-content/uploads/sites/2/colorlib-custom-web-design.png.avif" alt="">

                <!-- Social Tags Section -->
                <div class="socialtags">
                    <h4>Follow Us</h4>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                    <ul class="list">
                        @foreach ($news as $new)
                            <li class="li-container">
                                <img src="{{ asset( $new['image']) }}" class="card-img-top">
                                <a href="{{ url('News/' . $new['slug']) }}" class="text-decoration-none text-dark">
                                    <h5 class="card-title">{{ $new['title'] }}</h5>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
 $(document).ready(function() {
        let itemsToShow = 3;
        let totalItems = $(".featured").length;
        let offset = 3;

        $("#load-more").on("click", function(e) {
            e.preventDefault();

           
            $.ajax({
                url: '/ajaxnews', 
                type: 'GET',
                data: {
                    offset: offset,  
                    limit: itemsToShow 
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const news = response.data;  
                        if (news.length > 0) {
                           
                          news.forEach(function(news) {
                                const newsHtml = `
                                    <div class="col featured">
                                        <div class="card h-100 card-custom">
                                            <img src="${news.image}" class="card-img-top" alt="${news.title}">
                                            <div class="card-body">
                                                <a href="/Blog/${news.slug}" class="text-decoration-none text-dark">
                                                    <h5 class="card-title">${news.title}</h5>
                                                    <p class="card-text">
                                                        ${news.description}
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#news-container').append(newsHtml); 
                            });
                            offset += itemsToShow;
                            if (offset >= response.count) {
                                $('#load-more').hide();
                            }
                        }
                    } else {
                        alert('Failed to load blogs.');
                    }
                },
                error: function() {
                    alert('An error occurred while loading more blogs.');
                }
            });
        });
        
    });
</script>
@endsection<style>
  .bread a {
    color: black; 
    text-decoration: none; 
    font-weight: 600; 
    transition: color 0.3s ease; 
  }
  
  .bread a:hover {
    color:#282aa7;
  }
  .cats{
    display: flex;
    flex-direction: column;
    text-decoration: none;
    list-style: none;
    padding-left: 10px;
    margin-bottom: 30px;
}
.cats li{
margin: 0;
}
.cats li a{
font-size: 20px;
}
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f0f2f5;
  color: #333;
  line-height: 1.7;
}

/* Main Container */
main {
  width: 90%;
  max-width: 1100px;
  margin: 10px auto;
  padding: 20px;
}

/* Section Title */
#news {
  font-size: 2.5rem;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 40px;
  text-align: center;
  position: relative;
}

#news::after {
  content: '';
  display: block;
  width: 80px;
  height: 4px;
  background-color: #007bff;
  margin: 10px auto 0;
  border-radius: 2px;
}

/* Card Container */
.card-custom {
  border: none;
  border-radius: 15px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background-color: #fff;
}

.card-custom:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

/* Card Image */
.card-img-top {
  object-fit: cover;
  height: 200px;
  transition: transform 0.3s ease;
}

.card-img-top:hover {
  transform: scale(1.05);
}

/* Card Body */
.card-body {
  padding: 20px;
  background-color: #ffffff;
  border-bottom-left-radius: 15px;
  border-bottom-right-radius: 15px;
}

/* Title Styling */
.card-title {
  font-size: 1.4rem;
  font-weight: 700;
  color: #333;
  margin-bottom: 10px;
  transition: color 0.3s ease;
}

.card-title:hover {
  color: #007bff;
}

/* Card Text */
.card-text {
  font-size: 1rem;
  color: #555;
  line-height: 1.6;
  margin-bottom: 15px;
}

.card-body h5:hover,
.card-body p:hover {
  color: #0056b3;
  transition: color 0.3s ease;
}

/* Link Styling */
a {
  text-decoration: none;
  color: inherit;
  display: ;
}

a:hover {
  color: inherit;
}

/* Responsive Design */
@media (max-width: 768px) {
  .card-title {
    font-size: 1.2rem;
  }

  .card-text {
    font-size: 0.95rem;
  }
}

@media (max-width: 576px) {
  #news {
    font-size: 1.8rem;
  }

  .card-title {
    font-size: 1rem;
  }

  .card-text {
    font-size: 0.85rem;
  }
}

/* List Styling */
.list {
  width: 100%;
  margin: 0; /* Remove left margin */
  padding: 0; /* Remove left padding */
  align-items: start;
}

.li-container {
  display: flex;
  align-items: center;  
  text-align: center;
  width: 100%;
  border-top: .5px solid #e9e5e5;
  padding-top: 10px;
  margin-left: 0; /* Remove any left margin */
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
  background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
    url("https://images.unsplash.com/photo-1503694978374-8a2fa686963a?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
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
