@extends('Frontend.Components.layout2')

@section('title', 'Contact')
@section('content2')
<main>
    <h1 class="contact-title">Contact Us</h1>
    {{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}

   

    <div class="form-container">
        <form action="{{ route('contact.send') }}" method="POST">
            @csrf
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" >
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" >
            </div>
            <div>
                <label for="message">Message</label>
                <textarea id="message" name="message" ></textarea>
            </div>
            <button type="submit">Send</button>
        </form>
        
        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif
        
    </div>
</main>
@endsection

<style>
    
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f9fc;
        margin: 0;
        padding: 0;
    }
    
    /* Title Styling */
    .contact-title {
        text-align: center;
        font-size: 2.5rem;
        color: #333;
        margin-top: 30px;
    }
    
    /* Success/Error Messages */
    .alert {
        text-align: center;
        padding: 10px;
        margin-top: 20px;
        border-radius: 5px;
    }
    
    .alert-success {
        background-color: #28a745;
        color: white;
    }
    
    .alert-danger {
        background-color: #dc3545;
        color: white;
    }
    
    /* Form Container Styling */
    .form-container {
        width: 100%;
        max-width: 600px;
        margin: 30px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Form Elements Styling */
    form label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #555;
    }
    
    form input, form textarea {
        width: 100%;
        padding: 12px;
        margin: 8px 0 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    form input:focus, form textarea:focus {
        border-color: #007bff;
        outline: none;
    }
    
    form textarea {
        resize: vertical;
    }
    
    .submit-btn {
        background-color: #007bff;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        width: 100%;
        cursor: pointer;
        font-size: 1.1rem;
        transition: background-color 0.3s ease;
    }
    
    .submit-btn:hover {
        background-color: #0056b3;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }
    }
    
    </style>

