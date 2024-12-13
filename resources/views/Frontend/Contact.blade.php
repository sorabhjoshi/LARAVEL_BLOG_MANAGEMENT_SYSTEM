@extends('Frontend.Components.layout2')

@section('title', 'Contact')
@section('content2')
<main>
    <h1 class="contact-title">Contact Us</h1>

   

    <div class="form-container">
        <form method="POST" action="{{ route('contact.send') }}" class="contact-form">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required placeholder="Enter your name">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required placeholder="Subject">

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="3" required placeholder="Your message"></textarea>

            <button type="submit" class="submit-btn">Send</button>
        </form>
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

