<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalization.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">

</head>
<body>
    <nav class="nav-bar">
        <div class="container">
            <img src="{{ asset('images/assets/Logo.png') }}" alt="">
            <ul class="nav-bar-content">
                <li class="nav-bar-list-item active"><a href="{{route('viewCategories')}}">categories</a></li>
                <li class="nav-bar-list-item"><a href="{{route('viewProducts')}}">product</a></li>
                <li class="nav-bar-list-item"><a href="{{route('viewBrands')}}">brand</a></li>
                <li class="nav-bar-list-item"><a href="">reports</a></li>
            </ul>
        </div>
    </nav>
    <form class="container" method="POST" action="{{route('updateCategory' , $category->id)}}" enctype="multipart/form-data">
        @csrf
        <div class="input">
            <p>edit The Category Name</p>
            <input class="input-field" type="text" placeholder="Name" value="{{$category->name}}" name="name">
        </div>

        <div class="input">
            <p>Enter The Category Icon</p>
            <div>
                @if($category->image !== null)
                    <img src="{{asset("images/Categories/".$category->image)}}" alt="" height="100%">
                @endif
                <div>
                    <input class="input-file" type="file" placeholder="Image" name="image">
                </div>
            </div>
        </div>

        <input type="submit" class="submitbutton" value="Edit">

    </form>

</body>
</html>
