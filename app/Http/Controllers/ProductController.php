<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\FeedBack;
use App\Models\User;


use App\Http\Controllers\ImageController;

class ProductController extends Controller
{
    // get product page
    public function products(){
        $products =  Product::get();
        foreach ($products as $product){
            $category = Category::where("id" , $product->category)->get();
            $brand = Brand::where("id" , $product->brand)->get();
            $imagesObjects = Image::where('product' , $product->id)->get();
            $images = array();
            foreach($imagesObjects as $image){
                $images[] = $image->imageName;
            }
            $product->category = $category[0]->name;
            $product->brand = $brand[0]->name;
            $product["images"] = $images;
        }
        return view("products.main")->with("products" , $products);
    }

    // get the categories and brands then send it to the add product view page
    public function addProduct(){
        $brands = Brand::get();
        $categories = Category::get();
        return view("products.addProduct")->with('brands' , $brands)->with("categories" , $categories);
    }

    // add product to database
    public function addProductPost(Request $request){

        $image = $request->file("mainImage");
        $ext = $image->getClientOriginalExtension();
        $mainImage = "ProductImage-".uniqid().".". $ext;
        $image->move(public_path('images/Products') , $mainImage);

        $image = $request->file('descriptionImage');
        $ext = $image->getClientOriginalExtension();
        $descriptionImage = "ProductImage-".uniqid().".". $ext;
        $image->move(public_path('images/Products') , $descriptionImage);

        $product = Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price'=> $request->price,
            'mainImage' => $mainImage,
            'description' => $request->description,
            'descriptionImage' => $descriptionImage,
            'brand' => $request->brand,
            'quantity' => $request->quantity
        ]);

        foreach ($request->Images as $image){
            $ext = $image->getClientOriginalExtension();
            $imageName = "ProductImage-".uniqid().".". $ext;
            $image->move(public_path('images/Products') , $imageName);

            ImageController::insertImage($product->id , $imageName);
        }
        return redirect(route("viewProducts"));
    }

    // delete product from database
    public function deleteProduct($id){
        $product = Product::findOrFail($id);
        $images = Image::where('product' , $id)->get();
        foreach($images as $image){
            unlink( public_path('images/Products/').$image->imageName);
        }
        unlink( public_path('images/Products/').$product->mainImage);
        unlink( public_path('images/Products/').$product->descriptionImage);
        $product->delete();
        return redirect(route('viewProducts'));
    }


    // edit product Page
    public function editProduct( string $id){

        $brands = Brand::get();
        $categories = Category::get();
        $product =Product::findOrFail($id);

        $images = Image::where('product' , $id)->get();

        return view("products.editProduct")->with('brands' , $brands)->with("categories" , $categories)->with('product' , $product)->with('images' , $images);
    }

    public function updateProduct(Request $request , $id){
        $product = Product::findOrFail($id);
        $mainImage = $product->mainImage;
        $descriptionImage = $product->descriptionImage;

        if($request->hasFile('mainImage')){
            if( $product->mainImage !== null){
                unlink( public_path('images/Products/').$product->mainImage);
            }
            $image = $request->file("mainImage");
                $ext = $image->getClientOriginalExtension();
                $mainImage = "ProductImage-".uniqid().".". $ext;
                $image->move(public_path('images/Products') , $mainImage);
        }

        if($request->hasFile('descriptionImage')){
            if( $product->descriptionImage !== null){
                unlink( public_path('images/Products/').$product->descriptionImage);
            }
            $image = $request->file("descriptionImage");
            $ext = $image->getClientOriginalExtension();
            $descriptionImage = "ProductImage-".uniqid().".". $ext;
            $image->move(public_path('images/Products') , $descriptionImage);
        }

        if($request->hasFile('Images')){
            foreach ($request->Images as $image){
                $ext = $image->getClientOriginalExtension();
                $imageName = "ProductImage-".uniqid().".". $ext;
                $image->move(public_path('images/Products') , $imageName);
                ImageController::insertImage($product->id , $imageName);
            }
        }

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'price'=> $request->price,
            'mainImage' => $mainImage,
            'description' => $request->description,
            'descriptionImage' => $descriptionImage,
            'brand' => $request->brand,
            'quantity' => $request->quantity
        ]);

        return redirect(route('viewProducts'));

    }

    // get product list to the API
    public function allNewAddedProducts(){
        $products =  Product::select('id', 'name' , 'category' , 'price' , 'mainImage' , 'brand')->orderBy('created_at', 'DESC')->paginate(20);

        foreach ($products as $product){

            $category = Category::where("id" , $product->category)->get();
            $brand = Brand::where("id" , $product->brand)->get();
            $avgRate =FeedBack::where('product' , $product->id )->avg('rate');

            if($avgRate === null){
                $avgRate = 0;
            }

            $product->mainImage = "http://192.168.1.9/Gaya-Store/public/images/Products/".$product->mainImage;

            $product->category = $category[0]->name;
            $product->brand = $brand[0]->name;
            $product['rating'] =$avgRate;

        }

        $products = json_encode($products);
        $products = json_decode($products);

        return response()->json([
            "status" => 'Ok',
            "message" => "Data Retrieved Successfully",
            "page" =>$products->current_page,
            "products" => $products->data,
        ],200);
    }

    // get product list to the API
    public function getProductsByCategory(Request $request){
        $products =  Product::select('id', 'name' , 'category' , 'price' , 'mainImage' , 'brand')->where("category" , $request->categoryId)->get();

        foreach ($products as $product){

            $category = Category::where("id" , $product->category)->get();
            $brand = Brand::where("id" , $product->brand)->get();
            $avgRate =FeedBack::where('product' , $product->id )->avg('rate');

            if($avgRate === null){
                $avgRate = 0;
            }

            $product->mainImage = "http://192.168.1.9/Gaya-Store/public/images/Products/".$product->mainImage;

            $product->category = $category[0]->name;
            $product->brand = $brand[0]->name;
            $product['rating'] =$avgRate;

        }

        return response()->json([
            "status" => 'Ok',
            "message" => "Data Retrieved Successfully",
            "page" => 1,
            "products" => $products,
        ],200);
    }

    // get product details for api
    public function getProductDetails(Request $request){

        $user = User::where('token' ,"=", $request->token)->get();
        $product = Product::findOrFail($request->product_id);
        $category = Category::where("id" , $product->category)->get();
        $brand = Brand::where("id" , $product->brand)->get();
        $imagesObjects = Image::where('product' , $product->id)->get();
        $avgRate =FeedBack::where('product' , $product->id )->avg('rate');
        $userFeedBack = FeedBack::where("user",'=', $user[0]->id)->where("product",'=', $product->id)->select('rate' , 'comment')->get();
        $productFeedback = FeedBack::where("user",'<>', $user[0]->id)->where("product",'=', $product->id)->select('user' , 'rate' , 'comment')->paginate(4);

        if($avgRate === null){
            $avgRate = 0;
        }
        $images = array();

        $images[] = "http://192.168.1.9/Gaya-Store/public/images/Products/".$product->mainImage;
        foreach($imagesObjects as $image){
            $images[] = "http://192.168.1.9/Gaya-Store/public/images/Products/".$image->imageName;
        }

        $product->mainImage = "http://192.168.1.9/Gaya-Store/public/images/Products/".$product->mainImage;
        $product->descriptionImage = "http://192.168.1.9/Gaya-Store/public/images/Products/".$product->descriptionImage;
        $userRate = null;
        $userComment = null;

        if(count($userFeedBack)>0){
            $userRate = $userFeedBack[0]->rate;
            if($userFeedBack[0]->rate === null){
                $userRate = 0;
            }
            $userComment = $userFeedBack[0]->comment;
            if($userFeedBack[0]->comment === null){
                $userComment = '';
            }
        }

        $productFeedBacks = null;

        if(count($productFeedback)>0){
            foreach($productFeedback as $feedback){
                $userInfo =User::where('id' ,'=', $feedback['user'])->get();
                $feedback['user'] = $userInfo[0]->name;
                $feedback['userImage'] = "http://192.168.1.9/Gaya-Store/public/images/UserImages/".$userInfo[0]->image;
            }
            $productFeedBacks = $productFeedback->toArray()['data'];
        }

        $product->category = $category[0]->name;
        $product->brand = $brand[0]->name;
        $product['rating'] =$avgRate;
        $product['userRating'] = $userRate;
        $product['userComment'] = $userComment;
        $product['feedBack'] = $productFeedBacks;
        $product["images"] = $images;

        return response()->json([
            "status" => 'Ok',
            "message" => "Data Retrieved Successfully",
            "product" => $product,
        ],200);
    }

    public function productSearch(Request $request){
        $products = Product::select('id', 'name' , 'category' , 'price' , 'mainImage' , 'brand')->where('name', 'like' , '%'.$request->query_term.'%')->get();

        foreach ($products as $product){

            $category = Category::where("id" , $product->category)->get();
            $brand = Brand::where("id" , $product->brand)->get();
            $avgRate =FeedBack::where('product' , $product->id )->avg('rate');

            if($avgRate === null){
                $avgRate = 0;
            }

            $product->mainImage = "http://192.168.1.9/Gaya-Store/public/images/Products/".$product->mainImage;

            $product->category = $category[0]->name;
            $product->brand = $brand[0]->name;
            $product['rating'] =$avgRate;

        }

        return response()->json([
            "status" => 'Ok',
            "message" => "Data Retrieved Successfully",
            "page" => 1,
            "products" => $products,
        ],200);
    }
}
