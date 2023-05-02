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

    <div class="container">
        <form action="{{route('updateProduct' , $product->id)}}" method="POST" enctype="multipart/form-data" style="background-color: ">
            @csrf
            <label for="" class="label-style">Name</label>
            <input type="text" name='name' placeholder="name" class="Product-Input" value="{{$product->name}}">

            <label for="" class="label-style">Category</label>
            <select name="category" id="" class="Product-Input-DropDown">
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>

            <label for="" class="label-style">Price</label>
            <input type="number" name='price' placeholder="Price" class="Product-Input" value="{{$product->price}}">

            <label for="" class="label-style">Main Image</label>
            <div class="Product-Input">
                <img src="{{asset("images/Products/".$product->mainImage)}}" alt="" height="100px" >
                <input type="file" name='mainImage' placeholder="Main Image" value="{{$product->mainImage}}">
            </div>
            <label for="" class="label-style">Description</label>
            <input type="text" name='description' placeholder="Description" class="Product-Input" value="{{$product->description}}">
            <label for="" class="label-style">Description Image</label>
            <div class="Product-Input">
                <img src="{{asset('images/Products/'.$product->descriptionImage)}}" alt="" height="400px">
                <input type="file" name='descriptionImage' placeholder="Description Image" value="{{$product->descriptionImage}}">
            </div>
            <label for="" class="label-style">Brand</label>
            <select name="brand" id="" class="Product-Input-DropDown">
                @foreach ($brands as $brand)
                <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select>

            <label for="" class="label-style">Quantity</label>
            <input type="number" name="quantity" placeholder="Quantity" class="Product-Input" value="{{$product->quantity}}">
            <label for="" class="label-style">Images</label>
            <input type="file" multiple name='Images[]' placeholder="Images" class="Product-Input">
            <div class="images-show">
                @foreach ($images as $image)
                <div class="image-show">
                    <img src="{{asset("images/products/".$image->imageName)}}" alt="">
                    <a href="{{route('deleteImage' , [$image->id , $product->id])}}" class="delete">Delete</a>
                </div>
                @endforeach
            </div>
            <input type="submit" class="submitbutton" value="Edit">
        </form>
    </div>
</body>
</html>

