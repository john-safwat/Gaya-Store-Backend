<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderProduct;

class OrderProductController extends Controller
{
    public function getOrders(){
        $order = OrderProduct::get();
        return response()->json(['order' => $order]);
    }
}
