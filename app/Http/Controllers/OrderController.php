<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\CartItem;



class OrderController extends Controller
{
    public function getOrders(){
        $orders = Order::get();

        return response()->json([
            'orders' => $orders
        ]);
    }

    public function addOrder(Request $request){
        $user =  User::where('token' ,'=' ,$request->token)->get();

        $order = Order::create([
            'userId' => $user[0]->id,
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber ,
            'address' => $request->address ,
            'cardNumber' => $request->cardNumber,
            'shippingState' => $request->shippingState,
            'shippingPrice' => $request->shippingPrice,
            'postalCode' => $request->postalCode,
            'total' => $request->total,
        ]);

        $products = [];
        if($request->products !== null){
            foreach($request->products as $product){
                $productToUpdate = Product::findOrFail($product['id']);
                $productToUpdate->quantity =$productToUpdate->quantity - $product['quantity'];
                $productToUpdate->update(['quantity' => $productToUpdate->quantity,]);
                $orderProduct =OrderProduct::create([
                    'orderId' => $order->id,
                    'productId' => $product['id'],
                    'quantity' => $product['quantity'],
                    'orderTotal' => $product['orderTotal']
                ]);
                $orderProduct->toArray();
                array_push( $products ,$orderProduct);
            }
        }
        $order['products'] = $products;

        CartItem::where('userId', '=' , $user[0]->id)->delete();
        return response()->json(
            [
                'statusCode' => 200 ,
                'message' => "Order Placed Successfully",
                'orderNumber' => $order['id'],
                'userName' =>$order['name'],
                'total' => $order['total'],
                'shippingCharge' => $order['shippingPrice']
            ]
        );
    }

    public function getOrdersHistory(Request $request){
        $user =  User::where('token' ,'=' ,$request->token)->get();
        $orders = Order::where('userId' , "=" , $user[0]->id)->get();

        if(count($orders)<=0){
            return response()->json([
                'status code' => 404,
                'message' => 'theres is no orders yet',
                'orders' => null
            ]);
        }
        foreach($orders as $order){
            $orderProducts = OrderProduct::where("orderId" , "=" , $order->id)->get();
            foreach($orderProducts as $orderProduct){
                $product = Product::where('id',"=" , $orderProduct->productId)->get();
                $orderProduct["productName"] = $product[0]->name;
            }
            $order["products"] = $orderProducts;
        }

        return response()->json([
            'status code' => 200,
            'message' => 'data retrieved successfully',
            'orders' => $orders
        ]);
    }

}
