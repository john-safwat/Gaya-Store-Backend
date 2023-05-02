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
                <li class="nav-bar-list-item"><a href="{{route('viewCategories')}}">categories</a></li>
                <li class="nav-bar-list-item"><a href="{{route('viewProducts')}}">product</a></li>
                <li class="nav-bar-list-item active"><a href="{{route('viewBrands')}}">brand</a></li>
                <li class="nav-bar-list-item"><a href="">reports</a></li>
            </ul>

        </div>
    </nav>
    <section class="container">
        <a href="{{ route('addBrand')}}">
            <div class="add-category">
                <img src="{{ asset('images/assets/addIcon.png') }}" alt="" class="add-image">
                <p>Add New Brand</p>
            </div>
        </a>
    </section>
    <div class="container">
        <section class="brands">
            @foreach ($brands as $brand)
                <div class = 'brand'>
                    <p>{{$brand->name}}</p>
                    <div>
                        <a href="{{route("editBrand" , $brand->id)}}" class="edit">Edit</a>
                        <a href="{{route("deleteBrand" , $brand->id)}}" class="delete">Delete</a>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
</body>
</html>
