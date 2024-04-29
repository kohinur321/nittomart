<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\GalleryImage;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function showProduct ()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
            $products = Product::orderBy('id', 'desc')->with('category', 'subCategory')->get();
            return view('backend.admin.product.list', compact('products'));
            }
    }
}
public function createProduct ()
{
    if(Auth::user()){
        if(Auth::user()->role == 1){
            $categories = Category::orderBy('name', 'asc')->get();
            $subCategories = SubCategory::orderBy('name', 'asc')->get();
            return view('backend.admin.product.create', compact('categories', 'subCategories'));
        }
     }

   }

   public function storeProduct (Request $request)
   {
    if(Auth::user()){
        if(Auth::user()->role == 1){
            $product = new Product();

            if(isset($request->image)){
                $imageName = rand().'-product-'.'.'.$request->image->extension();
                $request->image->move('backend/images/product/' ,$imageName);

                $product->image = $imageName;
               }

            $product->name = Str::slug($request->name);
            $product->slug = $request->name;
            $product->cat_id = $request->cat_id;
            $product->sub_cat_id = $request->sub_cat_id;
            $product->regular_price = $request->regular_price ;
            $product->discount_price = $request->discount_price ;
            $product->buy_price = $request->buy_price;
            $product->qty = $request->qty;
            $product->sku_code = $request->sku_code;
            $product->product_type = $request->product_type;
            $product->short_desc = $request->short_desc;
            $product->long_desc = $request->long_desc;
            $product->product_policy = $request->product_policy;

            $product->save();

              //Product Color
                if(isset($request->color)){
                    foreach($request->color as $name){
                        $color = new Color();

                        $color->product_id = $product->id;
                        $color->color_name = $name;
                        $color->save();
                    }
                }
                 //Product Size
                 if(isset($request->size)){
                    foreach($request->size as $name){
                        $size = new Size();

                        $size->product_id = $product->id;
                        $size->size_name = $name;
                        $size->save();
                    }
                }

                //Insert GalleryImage
                if(isset($request->galleryImage)){
                    foreach($request->galleryImage as $image){
                        $galleryImage = new GalleryImage();
                        $galleryImage->product_id = $product->id;

                        $imageName = rand().'-galleryImage-'.'.'.$image->extension();
                        $image->move('backend/images/galleryImage/' ,$imageName);
                        $galleryImage->image = $imageName;

                        $galleryImage->save();
                    }
                }

                toastr()->success('Product is Successfully Created!');
                return redirect()->back();
        }
    }
  }
}
