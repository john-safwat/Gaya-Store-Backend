<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    // get brands page
    public function brands(){
        $brands = Brand::get();

        return view('brands.main')->with("brands" ,$brands);
    }

    // add brands page
    public function addBrand() {
        return view("brands.addBrand");
    }

    // add brand to database
    public function addBrandPost(Request $request){

        Brand::create([
            'name' => $request->name ,
            'country' => $request->country ,
        ]);
        return redirect(route('viewBrands'));
    }

    // delete brands page
    public function deleteBrand($id){
        $brand = Brand::findOrFail($id);
        $brand-> delete();
        return redirect(route("viewBrands"));
    }

    // edit brand page (form)
    public function editBrand($id){
        $brand = Brand::findOrFail($id);

        return view('brands.editBrand')->with("brand",$brand);
    }

    // update brands page
    public function updateBrand(Request $request , $id){
        $brand = Brand::findOrFail($id);

        $brand->update([
            'name' => $request->name ,
            'country' => $request->country ,
        ]);

        return redirect(route('viewBrands'));
    }
}
