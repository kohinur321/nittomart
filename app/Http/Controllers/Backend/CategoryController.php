<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function createCategory ()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
              return view ('backend.admin.category.create');
            }
        }
    }

    public function storeCategory (Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $category = new Category();

                $category->name = $request->name;
                $category->slug = Str::slug($request->name);

                if(isset($request->image)){
                 $imageName = rand().'-category-'.'.'.$request->image->extension();
                 $request->image->move('backend/images/category/' ,$imageName);

                 $category->image = $imageName;
                }

                $category->save();
                toastr()->success('Successfully Created!');
                return redirect()->back();
            }
        }
    }

    public function showCategory ()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $categories = Category::get();
                return view ('backend.admin.category.list', compact('categories'));
            }
        }
    }

    public function deleteCategory ($id)
    {
        if(Auth::user()->role ==1){
            $category = Category::find($id);

        if($category->image && file_exists('backend/images/category/'.$category->image)){
            unlink('backend/images/category/'.$category->image);
        }
        $category->delete();
        toastr()->success('Successfully Deleted!');
        return redirect()->back();
        }
    }

    public function editCategory ($id)
    {
        if(Auth::user()){
            if(Auth::user()->role ==1){
                $category = Category::find($id);
        return view('backend.admin.category.edit', compact('category'));
            }
        }
    }
    public function updateCategory(Request $request, $id)
    {
      if(Auth::user()){
        if(Auth::user()->role ==1){
            $category = Category::find($id);

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);

            if(isset($request->image)){
                if($category->image && file_exists('backend/images/category/'.$category->image)){
                    unlink('backend/images/category/'.$category->image);
                }
             $imageName = rand().'-categoryup-'.'.'.$request->image->extension();
             $request->image->move('backend/images/category/',$imageName);

             $category->image = $imageName;

            }

            $category->save();
            toastr()->success('Successfully Updated!');
            return redirect('/admin/category/list');
        }
      }
    }
}

