<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index ()
    {
        $hotProducts = Product::where('product_type', 'hot')->orderBy('id', 'desc')->get();
        $newProducts = Product::where('product_type', 'new')->orderBy('id', 'desc')->get();
        $regularProducts = Product::where('product_type', 'regular')->orderBy('id', 'desc')->get();
        $discountProducts = Product::where('product_type', 'discount')->orderBy('id', 'desc')->get();
        return view ('home.index', compact('hotProducts', 'newProducts', 'regularProducts', 'discountProducts'));
    }

    public function productDetails ($slug)
    {
        $product = Product::where('slug', $slug)->with('color', 'size', 'galleryImage')->first();

        return view ('home.product-details', compact('product'));
    }

     public function viewCart ()
     {
        return view('home.view-cart');
     }

     public function productcheckout ()
     {
        return view('home.checkout');
     }

     public function shopProduct ()
     {
        return view('home.shop');
     }

     public function returnProduct ()
     {
        return view('home.return-product');
     }

     public function Privecy ()
     {
        return view('home.privecy-policy');
     }
}
