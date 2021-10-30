<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Profiles</title>
    <style>

 
        .profile-picture {
            width: 300px;
            object-fit: cover;
            object-position: center;
            height: 300px;
        }

        .profile-picture>img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 6px solid rgb(101, 219, 101);
        }

        .edit-btn{
            background-color:  rgb(34, 173, 21);
            color: #fff !important;
        }

    </style>
</head>

<body>
    @include("navbar");

    <div class="profile-page">

        <div class="sub-page text-center mt-5">
            @if(Session::get('fail'))
            <div class="alert alert-danger text-danger">
            {{ Session::get("fail") }}
            </div>
            @endif
            <div class="profile-picture mx-auto">
                <img src="{{ $userInfo->profile }}" id="image" alt="profile">
            </div>

            <div class="btnss mx-auto mt-3">
                <button class="btn edit-btn me-3" onclick="toggleUpload()"> <i class="fa fa-edit"></i>
                    Edit profile</button>
                <button class="btn btn-danger"> <i class="fa fa-trash"></i> Delete profile</button>
            </div>

            <form action="{{ route("upload.profile") }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                <input type="file" id="file" accept=".jpg,.png,.gif,.svg" onchange="priviewImage(event)" name="file" style="display: none">
                <button class="btn btn-success me-3" id="upload-btn" style="display: none">Upload</button>
            </form>
        </div>

    </div>

    <script>
        setInterval(() => {
            if (document.getElementById("file").value.length > 0) {
                document.getElementById("upload-btn").style.display = "initial";
            } else {
                document.getElementById("upload-btn").style.display = "none";
            }
        }, 1);

        function toggleUpload() {
            document.getElementById("file").click();
        }

        function priviewImage(e) {
            let file = e.target.files[0];
    
            let reader = new FileReader();
            let url = reader.readAsDataURL(file);

            reader.onloadend = function(e) {
              document.getElementById("image").src = reader.result;
            }
        }
    </script>
</body>

</html>
