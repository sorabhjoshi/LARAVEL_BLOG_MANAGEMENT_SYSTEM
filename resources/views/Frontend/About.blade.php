@extends('Frontend.Components.layout2')

@section('title', 'About')
@section('content2')
<main>
  
  <div class="container text-center my-5">
    <h1 class="display-4 mb-3">About Us</h1>
    <p class="lead mb-4">We are dedicated to providing insightful blogs and the latest news to keep you informed. Our goal is to engage, inform, and inspire our readers.</p>
  </div>

  
  <div class="container my-5">
    <h2 class="text-center mb-4">Our Mission</h2>
    <p class="text-center fs-5">
      Our mission is to create a platform where people can read insightful blogs on a variety of topics and stay updated with the latest news. 
      We strive to provide content that is not only informative but also thought-provoking and engaging, helping our audience stay well-informed.
    </p>
  </div>

  
  <div class="container my-5">
    <h2 class="text-center mb-4">Contact Us</h2>
    <p class="text-center fs-5">
      We value your feedback! Have any questions or suggestions? We'd love to hear from you. Feel free to reach out to us anytime.
    </p>
    <div class="text-center">
      <a href="{{ route('Contact') }}" class="btn btn-primary btn-lg">Email Us</a>
    </div>
  </div>
</main>
@endsection



