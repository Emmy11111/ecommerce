<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Register</title>
    <style>
    body{
        background-color: #ffffff;
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
        font-size: 13px;
        position: relative;
    }
    </style>
</head>
<body>

    @include("../navbar")

   <div class="form-container mx-auto mt-4 mb-4 col-xl-4 col-md-6 col-sm-8 border rounded p-4">
       <h3 class="fw-bold my-2 mb-4">Sign Up</h3>
       <form action="{{ route("register.user") }}" method="POST">
           @csrf
           <div class="input-cont mb-4">
               <input type="text" class="form-control  ps-4" @if(old("full_name"))value={{ old("full_name") }}@endif name="full_name" placeholder="Full name">
               <small class="error">@error("full_name"){{ $message }} @enderror</small>
            </div>

           <div class="input-cont mb-4">
            <input type="email" placeholder="Email address" class="form-control  ps-4" name="email" value={{ old("email") }}>
            <small class="error">@error("email"){{ $message }} @enderror</small>
        </div>

        <div class="input-cont mb-4">
            <input type="number" placeholder="Phone number" class="form-control  ps-4" name="phone" value={{ old("phone") }}>
            <small class="error">@error("phone"){{ $message }} @enderror</small>
        </div>

        <div class="input-cont mb-4">
            <input type="password" placeholder="Password" class="form-control  ps-4" name="password">
            <small class="error">@error("password"){{ $message }} @enderror</small>
        </div>

        <div class="input-cont mb-4">
            <button class="btn  text-white signup-btn w-100">Create account</button>
        </div>

        <div class="form-check">
            <input type="checkbox" required class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">I am agree with <a href="" class="text-decoration-none">terms and contitions</a></label>
          </div>
       </form>
   </div>

   <div class="input-cont text-center mb-4 mx-auto mb-5">
    <p>Already have an account? <a href="/login" class="text-decoration-none">Login</a></p>
</div>
</body>
</html>