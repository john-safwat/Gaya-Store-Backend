<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // the main view of the categories
    public function categories(){

        //get all the categories from the database and send it to the view
        $Categories = Category::get();
        return view('categories.main')->with("Categories" , $Categories);

    }

    // the form to add category
    public function addCategory(){
        return view('categories.addCategoryForm');
    }

    // the post request to add the category to the database
    public function addCategoryPost(Request $request){

        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imageName = "CategoryImage-".uniqid().".". $ext;
        $image->move(public_path('images/Categories') , $imageName);
        Category::create([
            'name' => $request['name'],
            'image' => $imageName,
        ]);

        return redirect(route("viewCategories"));
    }

    // delete category from database
    public function deleteCategory($id){
        $category = Category::findOrFail($id);
        if ($category->image !== null){
            unlink( public_path('images/Categories/').$category->image);
        }
        $category-> delete();
        return redirect(route("viewCategories"));
    }
    // edit category in database
    public function editCategory($id){
        $category = Category::findOrFail($id);
        return view('categories.editCategory')->with("category" , $category);
    }

    //update category in database
    public function updateCategory(Request $request , $id){
        $category = Category::findOrFail($id);
        $image = $category->image;
        $imageName = $category->image;
        if($request->hasFile('image')){

            if($imageName !== null){
                unlink( public_path('images/Categories/').$category->image);

            }

            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = "CategoryImage-".uniqid().".". $ext;
            $image->move(public_path('images/Categories') , $imageName);
        }
        $category->update([
            'name' => $request->name,
            'image'=> $imageName,
        ]);

        return redirect(route("viewCategories"));

    }

    // get categories list to api
    public function getCategories(){
        $Categories = Category::get();

        foreach($Categories as $Category){
            $Category->image = "http://192.168.1.9/Gaya-Store/public/images/Categories/".$Category->image;
        }

        return response()->json(
            [
                "Status_Code"=>"200",
                "Message" => "Data Loaded Successfully",
                "Categories" => $Categories,
            ],200
        );
    }
}
