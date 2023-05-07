<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('users/create' , 'App\Http\Controllers\UserController@create');
Route::post('users/uploadImage' , 'App\Http\Controllers\UserController@uploadImage');
Route::post('users/login' , 'App\Http\Controllers\UserController@login');
Route::get('users/userData' , 'App\Http\Controllers\UserController@getUserData');
Route::post('users/updateUserData' , 'App\Http\Controllers\UserController@updateUserData');

Route::get('home/category/categories' , 'App\Http\Controllers\CategoryController@getCategories');

// get all new added products
Route::get('home/product/allNewAddedProducts' , 'App\Http\Controllers\ProductController@allNewAddedProducts');
// get products by category id
Route::get('home/product/getProductsByCategory' , 'App\Http\Controllers\ProductController@getProductsByCategory');
// get product details
Route::get('home/product/productDetails' , 'App\Http\Controllers\ProductController@getProductDetails');
// get product after search
Route::get('home/product/productSearch' , 'App\Http\Controllers\ProductController@productSearch');
// get feedbacks
Route::get('home/product/feedback' , 'App\Http\Controllers\FeedBackController@getFeedBacks');
Route::post('home/product/addFeedBack' , 'App\Http\Controllers\FeedBackController@addFeedBack');
// get cart items
Route::get('home/product/cart' , 'App\Http\Controllers\CartItemController@getCart');
Route::post('home/product/addToCart' , 'App\Http\Controllers\CartItemController@addToCart');
Route::post('home/product/deleteFromCart' , 'App\Http\Controllers\CartItemController@deleteFromCart');
// orders
Route::get('home/order/allOrders' , 'App\Http\Controllers\OrderController@getOrders');
Route::post('home/order/addOrder' , 'App\Http\Controllers\OrderController@addOrder');
Route::get('home/order/getOrdersHistory' , 'App\Http\Controllers\OrderController@getOrdersHistory');

// orderProducts
Route::get('home/order/orderDetails' , 'App\Http\Controllers\OrderProductController@getOrders');

