<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <title>Register</title>
</head>
<body>
    <div class="container ">
        <form action="/register" method="POST">
            @csrf
            <h2 class="mb-4 text-center">Register Now!</h2>
        
           
            <div class="form-group mb-3">
                <label for="name">User Name</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter User Name" >
                @error('username')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            
            <div class="form-group mb-3">
                <label>Gender</label>
                <div>
                    <label for="male">
                        <input type="radio" name="gender" id="male" value="male" class="me-2" > Male
                    </label>
                </div>
                <div>
                    <label for="female">
                        <input type="radio" name="gender" id="female" value="female" class="me-2"> Female
                    </label>
                </div>
                @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            
            <div class="form-group mb-3">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" >
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
        
        <img src="img/5326273.jpg" alt="Registration Image" class="img-fluid ">
    </div>

    <script src="/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>