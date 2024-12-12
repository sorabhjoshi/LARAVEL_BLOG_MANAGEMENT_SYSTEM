@extends('Frontend.Components.layout2')

@section('title', 'About')


@section('bread')
<div class="bread">
    <h3 style="text-self:right;">Blog Design</h3> <p><a href="{{ route('frontend') }}">Home</a>>><a href="{{ route('Blogs') }}">Blog Design</a> </p>
    
    </div>
@endsection


@section('content2')

<main>
    
    <div class="container my-5">
        <div class="row">
            <!-- Blog Posts Section -->
            <div class="col-md-9">
                <div class="row row-cols-1 row-cols-md-3 g-4" id="blogs-container">
                    @foreach ($Blogs as $index => $Blog)
                        <div class="col featured" @if($index >= 3) style="display: none;" @endif>
                            <div class="card h-100 card-custom">
                                <img src="{{ asset( $Blog->image) }}" class="card-img-top" alt="{{ $Blog->title }}">
                                <div class="card-body">
                                    <a href="{{ url('Blog/' . $Blog->slug) }}" class="text-decoration-none text-dark">
                                        <h5 class="card-title">{{ $Blog->title }}</h5>
                                        <p class="card-text">
                                            {{ Str::limit(strip_tags($Blog->description), 100, '...') }}
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
                    @foreach ($categories as $category)
            <li>
                <a href="{{ url('Blog/Category/' . $category->categorytitle) }}">
                    {{ $category->categorytitle }} - ({{ $category->blogs_count }})
                </a>
            </li>
        @endforeach
                </ul>
                <img class="img" src="https://colorlib.com/wp/wp-content/uploads/sites/2/colorlib-custom-web-design.png.avif" alt="">

             
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
                        @foreach ($Blogs as $Blog)
                            <li class="li-container">
                                <img src="{{ asset( $Blog->image) }}" class="card-img-top">
                                <a href="{{ url('Blog/' . $Blog->slug) }}">
                                    <h5 class="card-title">{{ $Blog->title }}</h5>
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
        let offset = 3;

        $("#load-more").on("click", function(e) {
            e.preventDefault();

           
            $.ajax({
                url: '/ajaxblogs', 
                type: 'GET',
                data: {
                    offset: offset,  
                    limit: itemsToShow 
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const blogs = response.data; 
                        console.log(response);
                        console.log(offset);
                        if (blogs.length > 0) {
                           console.log(blogs);
                            blogs.forEach(function(blog) {
                                const blogHtml = `
                                    <div class="col featured">
                                        <div class="card h-100 card-custom">
                                            <img src="${blog.image}" class="card-img-top" alt="${blog.title}">
                                            <div class="card-body">
                                                <a href="/Blog/${blog.slug}" class="text-decoration-none text-dark">
                                                    <h5 class="card-title">${blog.title}</h5>
                                                    <p class="card-text">
                                                        ${blog.description}
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#blogs-container').append(blogHtml); 
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
    .list {
  width: 100%;
  margin: 0; 
  padding: 0; 
  align-items: start;
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
.li-container {
  display: flex;
  align-items: center;  
  text-align: left;
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
.bread {
    background-color: #e1e1e1;
    padding: 15px;
  }
  .img {
    height: 280px;
    width: 100%;
    margin: 0 auto 0 auto;
  }

ul li a i {
  margin-right: 10px;
}
    /* Global Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        color: #333;
        line-height: 1.7;
    }

    /* Main Container */
    main {
        width: 90%;
        max-width: 1100px;
        margin: 20px auto;
        padding: 10px;
    }

    
    /* Section Title */
    #blogs {
        font-size: 2rem;
        font-weight: 600;
        color: #111;
        margin-bottom: 20px;
    }

    

    /* Blog Cards */
    .card-custom {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Card Image */
    .card-img-top {
        object-fit: cover;
        height: 200px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        transition: transform 0.3s ease;
    }

    .card-img-top:hover {
        transform: scale(1.1);
    }

    /* Card Body */
    .card-body {
        padding: 20px;
        background-color: #fff;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Title Styling */
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }

    /* Card Text */
    .card-text {
        font-size: 1rem;
        color: #555;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .card-body h5:hover {
        color: #52adbf;
        transition: all 0.3s ease;
    }
    .card-title:hover{
  color: #52adbf;
}
  
    .card-body p:hover {
        color: #52adbf;
        transition: all 0.3s ease;
    }

    /* Link Styling */
    a {
        text-decoration: none;
        color: inherit;
    }

    a:hover {
        color: inherit;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-custom {
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.1rem;
        }

        .card-text {
            font-size: 0.95rem;
        }

        .sidebar {
            margin-bottom: 30px;
        }
    }

    @media (max-width: 576px) {
        #blogs {
            font-size: 1.5rem;
        }

        .card-title {
            font-size: 1rem;
        }

        .card-text {
            font-size: 0.85rem;
        }

        .sidebar {
            padding: 15px;
        }
    }
    .bread{
    background-color: #e1e1e1;
    padding: 20px 20px 20px 105px ;
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