<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
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
                <li class="nav-bar-list-item active"><a href="{{route('viewProducts')}}">product</a></li>
                <li class="nav-bar-list-item"><a href="{{route('viewBrands')}}">brand</a></li>
                <li class="nav-bar-list-item"><a href="">reports</a></li>
            </ul>

        </div>
    </nav>
    <section class="container">
        <a href="{{ route('addProduct')}}">
            <div class="add-category">
                <img src="{{ asset('images/assets/addIcon.png') }}" alt="" class="add-image">
                <p>Add New Product</p>
            </div>
        </a>
    </section>
    <div class="container">
        <div class="product-list">
        @foreach ($products as $product)
        <div class="product">
            <img src="{{asset('images/Products/'.$product->mainImage)}}" alt="" class="main-image">
            <p class="product-brand">id : {{$product->id}}</p>
            <p class="product-title">{{$product->name}}</p>
            <p class="product-price">Price : {{$product->price}}$</p>
            <p class="product-category">Category : {{$product->category}}</p>
            <p class="product-brand">Brand : {{$product->brand}}</p>
            <p class="product-quantity">Quantity : {{$product->quantity}}</p>
            <!-- <p class="product-description">Description :<br> {{$product->description}}</p> -->
            <div class= 'product-images'>
                @foreach ($product->images as $image)
                    <img src="{{asset("images/Products/".$image)}}" alt="" class="product-image">
                @endforeach
            </div>
            <div class="buttons">
                <a href="{{route('editProduct' , $product->id)}}" class="edit">Edit</a>
                <a href="{{route('deleteProduct' , $product->id)}}" class="delete">Delete</a>
            </div>
        </div>
        @endforeach
        </div>
    </div>
</body>
</html>
