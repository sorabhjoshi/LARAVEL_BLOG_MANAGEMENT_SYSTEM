@extends('Frontend.Components.layout2')

@section('content2')
<main>
  
    <div class="container my-5">
      
      <div class="text-center mb-4">
        <h1 class="display-4 fw-bold text-primary">{{ $Page->title }}</h1>
      </div>
      
      <div class="text-left">
        <p class="lead text-muted fs-4">
          {!! $Page->description !!}
        </p>
      </div>
    </div>
    
</main>
@endsection
