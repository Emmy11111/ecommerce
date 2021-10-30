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
    <title>Add Product</title>
    <style>
        .add-btn {
            height: 45px;
            background-color: rgb(34, 173, 21) !important;
            color: #fff !important;
        }

        .error {
            color: rgb(235, 77, 85);
            font-size: 13px;
            position: relative;
        }

        .title-add {
            color: rgb(34, 173, 21);
        }

    </style>
</head>

<body>

    @include("../navbar")

    <form action="{{ route('add.product') }}" method="POST" class="row g-3 mx-auto col-xl-8 mb-5 p-4"
        enctype="multipart/form-data">
        @csrf
        <h4 class="fw-bold mt-4 mb-3 title-add">Add product</h4>

        <div class="col-md-4">
            <label for="inputState2" class="form-label">Product category</label>
            <select id="inputState2" name="category" class="form-select">
                <option value="" disabled selected>Select category</option>
                @foreach ($product_type as $type)
                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                @endforeach
            </select>
            <small class="error">@error('category'){{ $message }} @enderror</small>
        </div>

        <div class="col-md-4">
            <label for="inputEmail4" class="form-label">Product title</label>
            <input type="text" name="title" id="inputEmail4" class="form-control" value={{ old('title') }}>
            <small class="error">@error('title'){{ $message }} @enderror</small>
        </div>
        <div class="col-md-4">
            <label for="inputPassword4" class="form-label">Price (RWF)</label>
            <input type="number" class="form-control" name="price" value="{{ old('price') }}" id="inputPassword4">
            <small class="error">@error('price'){{ $message }} @enderror</small>
        </div>

        <div class="location row mt-4">
            <div class="col-4">
                <label for="inputAddress" class="form-label">Location (District)</label>
                <select id="inputState" onchange="getSector(this)" name="district" class="form-select">
                    <option value="" selected disabled>Select district</option>
                    @foreach ($districts as $district)
                        <option value={{ $district->districtcode }}>{{ $district->namedistrict }}</option>
                    @endforeach
                </select>
                <small class="error">@error('district'){{ $message }} @enderror</small>
            </div>

            <div class="col-4">
                <label for="inputState5" class="form-label">Location (Sector)</label>
                <select id="inputState5" onchange="getcell(this)" name="sector" class="form-select sectors">
                    <option value="" selected disabled> Select sector</option>
                    @foreach ($sectors as $sector)
                        <option value={{ $sector->sectorcode }} style="display: none;"
                            class="{{ $sector->districtcode }} sectors-options">{{ $sector->namesector }}</option>
                    @endforeach
                </select>
                <small class="error">@error('sector'){{ $message }} @enderror</small>
            </div>

            <div class="col-4">
                <label for="inputState4" class="form-label">Location (Cell)</label>
                <select id="inputState4" name="cell" class="form-select cells">
                    <option value="" selected disabled>Select cell</option>
                    @foreach ($cells as $cell)
                        <option value={{ $cell->codecell }} style="display: none;" class="{{ $cell->sectorcode }} cells-options">{{ $cell->nameCell }}</option>
                    @endforeach
                </select>
                <small class="error">@error('cell'){{ $message }} @enderror</small>
            </div>
        </div>

        <div class="col-12">
            <label for="inputAddress2" class="form-label">Phone number</label>
            <div class="add">
                <span>{{ $userInfo->phone }}</span>
                <input class="form-check-input ms-3 me-1" type="checkbox" id="gridCheck" name="phone-o"
                    value={{ $userInfo->phone }}>
                <label class="form-check-label" for="gridCheck">
                    Do you want to use this phone number?
                </label>
            </div>

        </div>

        <div class="col-12">
            <label for="oher-p">Or use other phone number</label>
            <input type="number" placeholder="Phone number" class="form-control mt-2 ps-4" id="other-p" name="phone"
                value={{ old('phone2') }}>
            <small class="error">@error('phone'){{ $message }} @enderror</small>
        </div>

        <div class="col-12">
            <label for="formFile" class="form-label">Add photo</label>
            <input class="form-control" name="file" type="file" id="formFile" onchange="priviewImage(event)">
            <small class="error">@error('file'){{ $message }} @enderror</small>
        </div>

        <div class="col-12 image my-0" id="p-image">
            <img src="" id="image" class="w-100 my-4">
        </div>

        <div class="col-12 text-center">
            <button type="submit" class="btn w-50 add-btn ">Post Product</button>
        </div>
    </form>

    <script>
        let radio = document.getElementById("gridCheck");
        let field = document.getElementById("other-p");
        
       setInterval(() => {

        radio.onchange = ()=>{

          radio.name = "phone";
          field.name = "";
        }

        if(field.value.trim().length>0){
          radio.disabled = true;
          radio.name = "";
          field.name = "phone";
        }else{
          field.name = "f";
          radio.name =  "phone";
          radio.disabled = false;
        }
       }, 1);

        function priviewImage(e) {
            let file = e.target.files[0];

            let reader = new FileReader();
            let url = reader.readAsDataURL(file);

            reader.onloadend = function(e) {
                document.getElementById("image").src = reader.result;
            }
        }

        function getSector(id) {

          let allcells = document.getElementsByClassName("cells-options");

         for (let a = 0; a < allcells.length; a++) {
         allcells[a].style.display = "none";
        }

        let selector2 = document.getElementsByClassName("cells")[0];
        selector2.value = "";

            let selector = document.getElementsByClassName("sectors")[0];
            selector.value = "";
            let allSectors = document.getElementsByClassName("sectors-options");

            for (let a = 0; a < allSectors.length; a++) {
                allSectors[a].style.display = "none";
            }

            let sectors = document.getElementsByClassName(id.value);

            for (let i = 0; i < sectors.length; i++) {
                sectors[i].style.display = "block";
            }
        }

        function getcell(id) {

            let selector = document.getElementsByClassName("cells")[0];
            selector.value = "";
            let allcells = document.getElementsByClassName("cells-options");

            for (let a = 0; a < allcells.length; a++) {
                allcells[a].style.display = "none";
            }

            let cells = document.getElementsByClassName(id.value);

            for (let i = 0; i < cells.length; i++) {
                cells[i].style.display = "block";
            }
        }
    </script>

</body>

</html>
