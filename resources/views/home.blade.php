<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <title>Products</title>

    <style>
        .image {
            height: 215px;
            object-fit: cover;
            object-position: center;
            width: 215px;
        }

        .image>img {
            width: 100%;
            height: 100%;
        }

        .second-part {
            border-left: 1px solid lavender;
            height: 100%;
        }

        .product-cont {
            height: 100%;
            width: 100%;
        }

        .product-cont2 {
            width: 65%;
            position: relative;
            right: 60px;
            height: 250px;
        }

        .price {
            color: #ff7575;
            font-size: 18px;
        }

        .title {
            font-size: 18px;
            color: #3f4042b9;
            cursor: pointer;
        }

        .descr>p,
        .ty {
            color: #3f4042b9;
            cursor: pointer;
        }

        .left-bar {
            width: 20%;
            position: relative;
            left: 60px;
        }

        .link2-o>a {
            text-decoration: none;
            color: #3f4042b9;
            font-size: 15px;
        }

        .ty {
            color: rgb(34, 173, 21);
        }

        .add-btn {
            background-color: rgb(34, 173, 21);
            color: #fff !important;
        }

        .paginaions {}

        @media screen and (max-width: 500px) {
            .left-bar {
                width: 90%;
                left: 0;
                display: block;
            }

            .product-cont2 {
                width: 90%;
                float: none;
                height: 400px;
            }

            .first-part {
                display: block !important;
                width: 100% !important;
                float: none !important;
            }

            .second-part {
                float: none !important;
                width: 100% !important;
            }
        }

        a {
            cursor: pointer;
        }

    </style>
</head>

<body>
    @include("navbar")

    <div class="home-page"><br><br>

        <div class="left-bar border rounded mt-3 float-start p-3">
            <h6 class="ty mb-3">Product type</h6>

            <div class="links2 border-bottom mb-3">
                <ul>
                    @foreach ($product_type as $type)
                        <li>
                            <p class="link2-o"><a @if ($url == "/products/all/type/$type->id") style="color: rgb(34, 173, 21) !important;font-weight: bold;" @endif
                                    href="/products/all/type/{{ $type->id }}/{{ 'updated_at' }}/{{ 'desc' }}">{{ $type->type }}</a>
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="districts-select">
                <h6 class="ty mb-3">Select Location</h6>
                <select class="form-select form-select-sm" onchange="sort(this.value)">
                    <option selected value="" disabled>Select Location</option>
                    <option @if (!isset($dist)) selected @endif
                        @if (isset($dist))
                        @if ($dist == 1) selected @endif @endif
                            value="{{ '/products/all/type/9/updated_at/desc/1' }}">All
                    </option>
                    <option value="/products/all/kigali/type/9/updated_at/desc">Kigali</option>
                    @foreach ($districts as $district)
                        <option @if (isset($dist))  @if ($dist==$district->districtcode) selected @endif
                    @endif
                    value={{ "/products/all/type/9/updated_at/desc/$district->districtcode" }}>{{ $district->namedistrict }}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="product-cont2 float-end">
            @if (!Session::has('search_results'))
                <select class="form-select form-select-sm" id="sort" onchange="sort(this.value)">
                    <option value="" selected disabled>Sort</option>
                    <option @if ($item == 'updated_at' && $cond == 'desc') selected @endif value="{{ $url . '/updated_at/desc' }}">Date: Newest to Oldest</option>
                    <option @if ($item == 'updated_at' && $cond == 'asc') selected @endif value="{{ $url . '/updated_at/asc' }}">Date: Oldest to Newest</option>
                    <option @if ($item == 'price' && $cond == 'desc') selected @endif value="{{ $url . '/price/desc' }}">Price: Highest to Lowest</option>
                    <option @if ($item == 'price' && $cond == 'asc') selected @endif value="{{ $url . '/price/asc' }}">Price: Lowest to Highest</option>
                </select>
            @endif

            @if (count($products) == 0)
                <h5 class="fw-bold mt-5">No products found</h5>
            @endif

            @if (Session::has('search_results'))

                @if (count(Session::get('search_results')) == 0)
                    <h5 class="fw-bold mt-5">No results found</h5>
                @else
                    <h5 class="fw-bold mb-3">Results: </h5>
                @endif

                @foreach (Session::get('search_results') as $search_result)
                    <div class="product-cont border rounded mt-3">
                        <div class="first-part w-75 p-3 float-start d-flex">
                            <div class="image">
                                <img src="{{ $search_result->file }}" class="rounded">
                            </div>

                            <div class="descr ms-4">
                                <h5 class="title mt-3 mb-3 fw-bold">{{ $search_result->title }}</h5>

                                <p><i class="fa fa-calendar"></i> {{ $search_result->updated_at }}</p>
                                <p><i class="fa fa-list-alt"></i> {{ $search_result->type }}</p>
                                <p><i class="fa fa-map-marker"></i> <span title="Country">Rwanda</span> | <span
                                        title="District">{{ $search_result->namedistrict }}</span> | <span
                                        title="Sector">{{ $search_result->namesector }}</span> | <span
                                        title="Cell">{{ $search_result->nameCell }}</span></p>
                            </div>

                        </div>

                        <div class="second-part w-25 float-end p-3">

                            <h5 class="price mt-3 mb-3 fw-bold">{{ $search_result->price }} RWF</h5>

                            <button class="btn add-btn w-100 mb-3"> <i class="fa fa-heart"></i> Add to favorite</button>
                            <button class="btn btn-light w-100 border"
                                onclick="displayPhone({{ $search_result->id }})"><i class="fa fa-phone"></i> <span
                                    id="{{ 'call' . $search_result->id }}">Call</span> <span style="display: none;"
                                    id="{{ $search_result->id }}">{{ $search_result->phone }}</span></button>
                        </div>
                    </div>
                @endforeach
            @endif

            <?php $a = 1;
            $b = 0; ?>

            @if (!Session::has('search_results'))
                @foreach ($products as $product)
                    <?php $b++;
                    if ($b == 11) {
                        $a++;
                        $b = 0;
                    } ?>
                    <div class="product-cont border rounded mt-3 <?php echo $a; ?>" @if ($a > 1) style="display: none;" @endif>
                        <div class="first-part w-75 p-3 float-start d-flex">
                            <div class="image">
                                <img src="{{ $product->file }}" class="rounded">
                            </div>

                            <div class="descr ms-4">
                                <h5 class="title mt-3 mb-3 fw-bold">{{ $product->title }}</h5>

                                <p><i class="fa fa-calendar"></i> {{ $product->updated_at }}</p>
                                <p><i class="fa fa-list-alt"></i> {{ $product->type }}</p>
                                <p><i class="fa fa-map-marker"></i> <span title="Country">Rwanda</span> | <span
                                        title="District">{{ $product->namedistrict }}</span> | <span
                                        title="Sector">{{ $product->namesector }}</span> | <span
                                        title="Cell">{{ $product->nameCell }}</span></p>
                            </div>

                        </div>

                        <div class="second-part w-25 float-end p-3">

                            <h5 class="price mt-3 mb-3 fw-bold">{{ $product->price }} RWF</h5>

                            <button class="btn add-btn w-100 mb-3"> <i class="fa fa-heart"></i> Add to favorite</button>
                            <button class="btn btn-light w-100 border" onclick="displayPhone({{ $product->id }})"><i
                                    class="fa fa-phone"></i> <span id="{{ 'call' . $product->id }}">Call</span> <span
                                    style="display: none;"
                                    id="{{ $product->id }}">{{ $product->phone }}</span></button>
                        </div>
                    </div>

                @endforeach
            @endif

            @if (count($products) > 10)
                <div class="paginaions my-5">
                    <div class="pagination">
                        <p class="page-item"><a class="page-link" onclick="prev()">Previous</a></p>
                        @for ($i = 0; $i < ceil(count($products) / 10); $i++)
                            <p @if($i+1>5) style="display: none;" @endif onclick="pagination('<?php echo $i + 1; ?>')" id="{{ $i + 1 }}" class="page-item">
                                <a class="page-link">{{ $i + 1 }}</a></p>
                        @endfor
                        <p class="page-item"><a class="page-link" onclick="next()">Next</a></p>
                    </div>
                </div>
            @endif
            <br>

        </div>

    </div>

    <script>
        const displayPhone = (id) => {
            document.getElementById("call" + id).style.display = "none";
            document.getElementById(id).style.display = "inline";
        }

        const sort = (url) => {
            window.location = url;
        }

        const pagination = (n) => {
            let prevPage = localStorage.getItem("page");
            let currProduct = document.getElementsByClassName(prevPage);

            if (prevPage != n) {
                for (let a = 0; a < currProduct.length; a++) {
                    document.getElementsByClassName(prevPage)[a].style.display = "none";
                }
            }

            localStorage.setItem('page', n);

            document.getElementById(n).classList.add("active");

            if (prevPage != n) {
                document.getElementById(prevPage).classList.remove("active");
            }
            let products = document.getElementsByClassName(n);

            for (let i = 0; i < products.length; i++) {
                document.getElementsByClassName(n)[i].style.display = "block";
            }
        }

        window.onload = () => {
            document.getElementById("1").classList.add("active");
            localStorage.setItem('page', "1");
        }

        const next = () => {

            let prevPage = localStorage.getItem("page");
            let nextPage = parseInt(prevPage, 10) + 1;

            let currProduct = document.getElementsByClassName(prevPage);
            let products = document.getElementsByClassName(nextPage);

            if (products.length > 0) {
                document.getElementById(prevPage).classList.remove("active");
                document.getElementById(nextPage).classList.add("active");
                for (let a = 0; a < currProduct.length; a++) {
                    document.getElementsByClassName(prevPage)[a].style.display = "none";
                }

                localStorage.setItem('page', nextPage);
                for (let i = 0; i < products.length; i++) {
                    document.getElementsByClassName(nextPage)[i].style.display = "block";
                }
            } else {

            }
        }

        const prev = () => {
            let currPage = localStorage.getItem("page");
            let prevPage = parseInt(currPage, 10) - 1;

            if (parseInt(currPage, 10) > 1) {

                document.getElementById(currPage).classList.remove("active");
                document.getElementById(prevPage).classList.add("active");

                let currProduct = document.getElementsByClassName(currPage);
                let prevProducts = document.getElementsByClassName(prevPage);

                for (let a = 0; a < currProduct.length; a++) {
                    document.getElementsByClassName(currPage)[a].style.display = "none";
                }

                localStorage.setItem('page', prevPage);
                for (let i = 0; i < prevProducts.length; i++) {
                    document.getElementsByClassName(prevPage)[i].style.display = "block";
                }
            }
        }
    </script>

</body>

</html>
