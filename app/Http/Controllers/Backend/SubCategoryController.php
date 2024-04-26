<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function showSubCategory ()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $subCategories = SubCategory::with('category')->get();
                return view('backend.admin.subcategory.list', compact('subCategories'));
            }
        }
    }

    public function createSubCategory ()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $categories = Category::get();
               return view('backend.admin.subcategory.create', compact('categories'));
            }
        }
    }
    public function storeSubCategory (Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
             $subCategory = new SubCategory();

             $subCategory->cat_id = $request->cat_id;
             $subCategory->name = $request->name;
             $subCategory->slug = Str::slug($request->name);

             $subCategory->save();
            toastr()->success('Successfully Created!');
            return redirect()->back();
            }
    }
}

public function editSubCategory ($id)
{
    if(Auth::user()){
        if(Auth::user()->role == 1){
            $subCategory = SubCategory::find($id);
            $categories = Category::get();
            return view('backend.admin.subcategory.edit', compact('subCategory', 'categories'));
   }
 }
}

public function updateSubCategory (Request $request, $id)
{
    if(Auth::user()){
    if(Auth::user()->role == 1){
        $subCategory = SubCategory::find($id);

             $subCategory->cat_id = $request->cat_id;
             $subCategory->name = $request->name;
             $subCategory->slug = Str::slug($request->name);

             $subCategory->save();
            toastr()->success('Successfully Updated!');
            return redirect()->back();
    }
  }
}
  public function deleteSubCategory ($id)
  {
    if(Auth::user()){
        if(Auth::user()->role == 1){
            $subCategory = SubCategory::find($id);
            $subCategory->delete();
            toastr()->success('Successfully Deleted!');
            return redirect()->back();
        }
     }
   }
}



