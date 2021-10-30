<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login</title>
    <style>
    body{
        /* background-color: #dddddd49; */
    }

    .input-cont>input{
         height: 45px;
         border-radius: 8px;
    }

    .input-cont>button{
        height: 45px;
         border-radius: 8px;
         background-color: rgb(34, 173, 21) !important;
         color: #fff;
    }

    .error{
        color: rgb(235, 77, 85);
    }

    .btn-google{
        background-color: #ff7575;
        color: white !important;
        border-radius: 8px;
        height: 45px;
    }
    .google-text{
        position: relative;
        top: 2px;
    }
    </style>
</head>
<body>

    @include("../navbar")

    @if(Session::get('auth'))
    <div class="error alert-danger py-2 mb-4 text-center text-danger">
    {{ Session::get("auth") }}
    </div>
    @endif

   <br><div class="form-container mx-auto mt-5 mb-5 col-xl-4 col-md-6 col-sm-8 border rounded p-4 bg-white">
       <h3 class="fw-bold my-2 mb-4">Sign In</h3>
       <form action="{{ route("auth.user") }}" method="post">
           @csrf

           <a href="#" class="btn w-100 btn-block mb-4 btn-google"><span class="google-text"> <i class="fa fa-google-plus"></i> &nbsp;  Sign in with Google</span></a>

           <div class="input-cont mb-4">
            <input type="email" placeholder="Email address" required class="form-control  ps-4" value="<?php if(isset($_COOKIE['email'])){echo $_COOKIE['email'];} ?>" name="email">
        </div>

        <div class="input-cont mb-3">
            <input type="password" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];} ?>" placeholder="Password" required class="form-control  ps-4" name="password">
        </div>

        <div class="form-floating input-cont clearfix mb-3">
            <p class="float-start"><input type="checkbox" @if(isset($_COOKIE['email']) and isset($_COOKIE['password'])) checked @endif name="remember_me" id="rememberMe" class="form-check-input"><label for="rememberMe" class="ms-1">Remember me</label></p>
            <a class="float-end text-decoration-none" href="/forgot-password">Forgot Password?</a>
             </div>

             @if(Session::get('fail'))
             <div class="error mb-4 text-center">
             {{ Session::get("fail") }}
             </div>
             @endif

        <div class="input-cont mb-4">
            <button class="btn  text-white signup-btn w-100">Login</button>
        </div>

        <div class="input-cont text-center mb-4">
            <p>Don't have an account?<a href="/register" class="text-decoration-none"> Register</a></p>
        </div>
       </form>
   </div>
</body>
</html>