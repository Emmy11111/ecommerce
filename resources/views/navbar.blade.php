<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
    <style>
        /* select{
        height: 40px;
    }

    nav{
        background-color: rgb(235, 77, 85);
        height: 70px;
    }

    ul{
        display: flex;
        position: absolute;
        top: 15px;
        right: 60px;
    }

    li{
        list-style-type: none;
    }

    li > a {
    font-size: 15px;
    position: relative;
    color: rgba(255, 255, 255, 0.7) !important;
    padding: 20px 0px;
    text-decoration: none !important;
}

.active>a{
    color: #fff !important;
}

.profile-cont{
            width: 50px;
            height: 50px;
            object-fit: cover;
            object-position: center;
        }

        .profile-cont>img{
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .user-profile{
            position: relative;
            top: -5px;
            cursor: pointer;
            user-select: none;
        } */

        #search-input {
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
        }

        .search-engine {
            width: 35%;
            position: absolute;
            top: 15px;
            left: 50px;
        }

        nav {
            height: 70px;
        }

        .bgs {
            background-color: rgb(34, 173, 21) !important;
            color: #fff !important;
        }

        .link1>button {
            border-radius: 50%;
            height: 50px;
            width: 50px;
            border: 1px solid rgb(213, 213, 243);
            font-size: 23px;
            color: gray;
            background-color: #fff !important;
            object-fit: cover;
            object-position: center;
            padding: 0;
        }

        .form-outline {
            width: 90%;
        }

        .links {
            position: absolute;
            right: 50px;
        }

        .sl,
        .nav-link {
            color: #343a40;
            text-decoration: none
        }

        .user-profile-c>button>img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .profile-menu {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            z-index: 10;
        }

        .p-menu {
            background-color: #fff;
            width: 200px;
            float: right;
            position: relative;
            top: 60px;
            right: 40px;
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">

        <form action="{{ route('search.products', [9, 'updated_at', 'desc']) }}" method="POST"
            class="input-group search-engine">
            @csrf
            <div class="form-outline">
                <input id="search-input" autocomplete="off" type="search" id="form1" placeholder="Search" name="key"
                    class="form-control" />
            </div>
            <button id="search-button" type="submit" class="btn bgs">
                <i class="fa fa-search"></i>
            </button>
        </form>

        <div class="links d-flex">
            <a href="/products/all/type/9/updated_at/desc" class="text-decoration-none text-dark link1 me-3"><button><i
                        class="fa fa-home"></i></button></a>
            @if (Session('LoggedUser'))
            <a href="/add_product" class="nav-link me-3">Add Product</a>
            <a href="/products/all" class="nav-link me-3">Products</a>
            @endif
            <a @if (Session('LoggedUser')) onclick="toggle_menu()" @endif class="text-decoration-none text-dark link1 user-profile-c me-3"><button>
                    @if (Session('LoggedUser'))
                        @if ($userInfo->profile != '/images/user.png') <img
                            src={{ $userInfo->profile }} alt="">@endif @else <i class="fa fa-user"></i>
                        @endif
                </button></a>

            <div class="text me-3">
                <span class="text-muted">Welcome!</span>
                <div>
                    @if (!Session('LoggedUser')) <a href="/login"
                            class="text-decoration-none sl">Sign in</a> |
                        <a href="/register" class="text-decoration-none sl"> Register</a>
                    @else
                        <span>{{ substr($userInfo->full_name, 0, 12) }}@if (strlen($userInfo->full_name) > 12){{ '...' }}@endif</span>
                    @endif
                </div>
            </div>
        </div>

    </nav>

    @if (Session('LoggedUser'))
        <div class="profile-menu" id="profile-menu">
            <div class="p-menu bg-white p-3 rounded shadow-lg">
                <p><a href="/profiles" class="sl">Profiles</a></p>
                <p><a href="" class="sl">Settings</a></p>

                <div class="py-2">
                    <a href="/logout" class="text-danger text-decoration-none">Logout</a>
                </div>
            </div>
        </div>
    @endif

    {{-- <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">

        <div class="search-engnine mx-auto">
            <input type="text" placeholder="Search products" autocomplete="off" name="key" class="form-control shadow-none">
        </div>

        <ul class="site-menu main-menu js-clone-nav ml-auto ">
        <li class="active"><a href="#" class="nav-link">Home</a></li>
        <li><a href="/add_product" class="nav-link">Add Product</a></li>
        <li><a href="#" class="nav-link">Notifications</a></li>
        @if (Session('LoggedUser'))<li><a href="#" class="nav-link">Services</a></li>@endif

        <li><select class="form-select form-select-sm ms-3">
            <option disabled>Select Location</option>
            <option value="1" selected>All</option>
            <option value="2">Kigali</option>
            @foreach ($districts as $district)
            <option value={{ $district->districtcode }}>{{ $district->namedistrict }}</option>
            @endforeach
          </select></li>

          @if (isset($userInfo))
          @if (Session('LoggedUser'))<li><div class="user-profile d-flex ms-5" onclick="displayBar()">
            <p class="mt-3 ms-2 text-light">{{ substr($userInfo->full_name,0,8) }}@if (strlen($userInfo->full_name) > 8){{ "..." }}@endif</p>
            &nbsp;<div class="profile-cont">
                <img src="{{ $userInfo->profile }}" alt="">
                </div>
        </div></li>@endif
          @endif

        @if (!Session('LoggedUser'))
        <li class="ms-3"><a href="/login" class="nav-link">Login</a></li>
        <li><a href="/register" class="nav-link">Create account</a></li>
        @endif

        </ul>
        </nav> --}}

    <script>
        let menu = document.getElementById("profile-menu");

        const toggle_menu = () => {
            menu.style.display = "block";
        }

        window.onclick = (e) => {
            if (e.target == menu) {
                menu.style.display = "none";
            }
        }
    </script>

</body>

</html>
