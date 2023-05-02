<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// categories data
Route::get('home/category/categories' , 'App\Http\Controllers\CategoryController@categories')->name('viewCategories');
Route::get('home/category/addCategory' , 'App\Http\Controllers\CategoryController@addCategory')->name('addCategory');
Route::post('home/category/addCategory/add' , 'App\Http\Controllers\CategoryController@addCategoryPost')->name('postCategory');
Route::get('home/category/deleteCategory/{id}' , 'App\Http\Controllers\CategoryController@deleteCategory')->name('deleteCategory');
Route::get('home/category/editCategory/{id}' , 'App\Http\Controllers\CategoryController@editCategory')->name('editCategory');
Route::post('home/category/editCategory/{id}' , 'App\Http\Controllers\CategoryController@updateCategory')->name('updateCategory');

// product data
Route::get('home/product/products' , 'App\Http\Controllers\ProductController@products')->name('viewProducts');
Route::get('home/product/addProduct' , 'App\Http\Controllers\ProductController@addProduct')->name('addProduct');
Route::post('home/product/addProduct/add' , 'App\Http\Controllers\ProductController@addProductPost')->name('postProduct');
Route::get('home/product/deleteProduct/{id}' , 'App\Http\Controllers\ProductController@deleteProduct')->name('deleteProduct');
Route::get('home/product/editProduct/{id}' , 'App\Http\Controllers\ProductController@editProduct')->name('editProduct');
Route::post('home/product/editProduct/{id}' , 'App\Http\Controllers\ProductController@updateProduct')->name('updateProduct');

// brands data
Route::get('home/brand/brands' , 'App\Http\Controllers\BrandController@brands')->name('viewBrands');
Route::get('home/brand/addBrand' , 'App\Http\Controllers\BrandController@addBrand')->name('addBrand');
Route::post('home/brand/addBrand/add' , 'App\Http\Controllers\BrandController@addBrandPost')->name('postBrand');
Route::get('home/brand/deleteBrand/{id}' , 'App\Http\Controllers\BrandController@deleteBrand')->name('deleteBrand');
Route::get('home/brand/editBrand/{id}' , 'App\Http\Controllers\BrandController@editBrand')->name('editBrand');
Route::post('home/brand/editBrand/{id}' , 'App\Http\Controllers\BrandController@updateBrand')->name('updateBrand');

// images data
Route::get('home/Image/deleteImage/{id}/{pid}' , 'App\Http\Controllers\ImageController@deleteImage')->name('deleteImage');

