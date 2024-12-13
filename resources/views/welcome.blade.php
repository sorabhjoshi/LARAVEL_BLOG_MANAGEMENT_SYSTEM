<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to My Blog</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            text-align: center;
            padding: 20px;
        }
        header {
            margin-bottom: 20px;
        }
        .welcome {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .buttons a {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #ff2d20;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .buttons a:hover {
            background-color: #e0261c;
        }
        footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1 class="welcome">Welcome to My Blog!</h1>
        </header>
        <div class="buttons">
        <a href="{{ route('login') }}">Log In</a>
        <a href="{{ route('register') }}">Register</a>
        </div>
        <footer>
            &copy; {{ date('Y') }} LaraBlogs. Created By Sourabh Joshi.
        </footer>
    </div>
</body>
</html>
