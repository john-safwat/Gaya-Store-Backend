<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\User;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FeedBack;


class CartItemController extends Controller
{
    // add item to cart
    public function addToCart(Request $request){
        $user = User::where('token','=',$request->token)->get();

        $cartItem = CartItem::where('userId' ,'=' ,$user[0]->id)->where('productId' , '=' , $request->productId)->get();


        if($cartItem->isEmpty()){
            $cart = CartItem::create([
                "userId" => $user[0]->id,
                "productId" => $request->productId,
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Product Add To Cart Successfully',
                "cartItem" => $cart
            ], 200);
        }else {
            $cartItem[0]->productId =  $request->productId;
            return response()->json([
                'code' => 409,
                'message' => 'Product is Already in Your Cart',
                "cartItem" => $cartItem[0]
            ], 409);
        }
    }

    // delete item from cart
    public function deleteFromCart(Request $request){
        $user = User::where('token','=',$request->token)->get();

        $cartItem = CartItem::where('userId' ,'=' ,$user[0]->id)->where('productId' , '=' , $request->productId)->get();

        if ($cartItem->isEmpty()){
            return response()->json([
                'code' => 404,
                'message' => 'Product is not in the cart',
                "cartItem" => null
            ], 404);
        }else {
            $cartItem[0]->delete();
            $cartItem[0]->productId = $request->productId;
            return response()->json([
                'code' => 200,
                'message' => 'Product Removed Successfully',
                "cartItem" => $cartItem[0]
            ], 200);
        }

    }

    // get  cart dat for the user
    public function getCart(Request $request){
        $user = User::where('token','=',$request->token)->get();
        $cartItems = CartItem::where('userId' ,'=' ,$user[0]->id)->get();

        foreach ($cartItems as $cartItem){

            $product = Product::select('id', 'name' , 'category' , 'price' , 'mainImage' , 'brand' , 'quantity')->where('id' , '=' , $cartItem->productId)->get();
            $category = Category::where("id" , $product[0]->category)->get();
            $brand = Brand::where("id" , $product[0]->brand)->get();
            $avgRate =FeedBack::where('product' , $product[0]->id )->avg('rate');

            if($avgRate === null){
                $avgRate = 0;
            }

            $product[0]->mainImage = "http://192.168.1.9/Gaya-Store/public/images/Products/".$product[0]->mainImage;

            $product->category = $category[0]->name;
            $product->brand = $brand[0]->name;
            $product[0]['rating'] =$avgRate;

            $cartItem['cartProduct'] = $product[0];
        }

        return response()->json([
            "status" => 'Ok',
            "message" => "Data Retrieved Successfully",
            "cartProducts" => $cartItems,
        ]);

    }
}
