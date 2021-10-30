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
            width: 25%;
        }

        .third-part {
            border-left: 1px solid lavender;
            height: 100%;
            width: 15%;
        }

        .product-cont {
            height: 100%;
            width: 100%;
            display: flex;
        }

        .product-cont2 {
            width: 80%;
            position: relative;
            /* right: 60px; */
            height: 250px;
        }

        .first-part {
            width: 60%;
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

    <div class="product-cont2 mx-auto">
        <?php $a = 1;
        $x = 0;
        $b = 0; ?>
        @if (count($products) > 0)
            <h5 class="fw-bold my-4">Products</h5>
        @endif
        @foreach ($products as $product)
            <?php $b++;
            $x++;
            if ($b == 11) {
                $a++;
                $b = 0;
            } ?>
            <div class="product-cont border rounded mt-3 <?php echo $a; ?>" @if ($a > 1) style="display: none;" @endif>
                <div class="first-part p-3 float-start d-flex">
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

                <div class="second-part p-3">

                    <h5 class="price mt-3 mb-3 fw-bold">{{ $product->price }} RWF</h5>

                    <button class="btn add-btn w-100 mb-3"> <i class="fa fa-heart"></i> Likes</button>
                    <button class="btn btn-light w-100 border" onclick="displayPhone({{ $product->id }})"><i
                            class="fa fa-phone"></i> <span id="{{ 'call' . $product->id }}">Call</span> <span
                            style="display: none;" id="{{ $product->id }}">{{ $product->phone }}</span></button>
                </div>
                <div class="third-part float-end p-3">

                    <h5 class="price mt-3 mb-3 fw-bold text-success">Actions</h5>

                    <button data-bs-toggle="modal" data-bs-target="#deleteProduct" onclick="deleteProduct({{ $product->id }})" class="btn btn-danger w-100 mb-3"> <i class="fa fa-trash"></i> Delete</button>
                    <a href="/products/update/{{ $product->id }}"><button class="btn add-btn w-100 mb-3"> <i class="fa fa-edit"></i> Edit</button></a>
                </div>
            </div>
            @if (count($products) == $x)<br><br>@endif

        @endforeach

        @if (count($products) == 0)
            <h5 class="fw-bold mt-5">No products found</h5>
        @endif
    </div>

    <!-- Modal4 -->
    <div class="modal fade" id="deleteProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Remove Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="" id="rem-link" class="text-decoration-none text-white"><button type="button"
                            class="btn btn-danger">Delete</button></a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const displayPhone = (id) => {
            document.getElementById("call" + id).style.display = "none";
            document.getElementById(id).style.display = "inline";
        }

        const deleteProduct = (id)=>{
            document.getElementById("rem-link").href = "/products/all/"+id;
        }
    </script>

</body>

</html>
