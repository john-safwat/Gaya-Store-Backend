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
                <li class="nav-bar-list-item active"><a href="{{route('viewProducts')}}">product</a></li>
                <li class="nav-bar-list-item"><a href="{{route('viewBrands')}}">brand</a></li>
                <li class="nav-bar-list-item"><a href="">reports</a></li>
            </ul>

        </div>
    </nav>

    <form action="{{route('postProduct')}}" method="POST" class="container" enctype="multipart/form-data">
        @csrf
        <label for="" class="label-style">Name</label>
        <input type="text" name='name' placeholder="name" class="Product-Input">

        <label for="" class="label-style">Category</label>
        <select name="category" id="" class="Product-Input-DropDown">
            @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>

        <label for="" class="label-style">Price</label>
        <input type="number" name='price' placeholder="Price" class="Product-Input">
        <label for="" class="label-style">Main Image</label>
        <input type="file" name='mainImage' placeholder="Main Image" class="Product-Input">
        <label for="" class="label-style">Description</label>
        <input type="text" name='description' placeholder="Description" class="Product-Input">
        <label for="" class="label-style">Description Image</label>
        <input type="file" name='descriptionImage' placeholder="Description Image" class="Product-Input">

        <label for="" class="label-style">Brand</label>
        <select name="brand" id="" class="Product-Input-DropDown">
            @foreach ($brands as $brand)
            <option value="{{$brand->id}}">{{$brand->name}}</option>
            @endforeach
        </select>

        <label for="" class="label-style">Quantity</label>
        <input type="number" name="quantity" placeholder="Quantity" class="Product-Input">

        <label for="" class="label-style">Imaegs</label>
        <input type="file" multiple name='Images[]' placeholder="Images" class="Product-Input">
        <input type="submit" class="submitbutton" value="Add">
    </form>
</body>
</html>
