<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
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

     //Add to cart---

     public function addtoCartDetails (Request $request, $id)
     {
       $cartProduct = Cart::where('product_id', $id)->where('ip_address', $request->ip())->first();
       $product = Product::where('id', $id)->first();
          $action = $request->action;

       if($cartProduct == null){
          $cart = new Cart();
          $cart->product_id = $id;
          $cart->ip_address = $request->ip();
          $cart->qty = $request->qty;
          if($product->discount_price !=null){
          $cart->price = $product->discount_price;
        }
        elseif($product->discount_price == null){
            $cart->price = $product->regular_price;
        }

        $cart->size = $request->size;
        $cart->color = $request->color;

        $cart->save();
        if($action == 'addToCart'){
            toastr()->success('Added to cart!');
            return redirect()->back();
        }
        else{
            toastr()->success('Added to cart!');
            return redirect('product/checkout');
        }
       }
       elseif($cartProduct != null){
        $cartProduct->qty = $cartProduct->qty + $request->qty;
        $cartProduct->save();
        if($action == 'addToCart'){
            toastr()->success('Added to cart!');
            return redirect()->back();
        }
        else{
            toastr()->success('Added to cart!');
            return redirect('product/checkout');
        }
       }
     }

     public function addtoCart (Request $request, $id)
     {
        $cartProduct = Cart::where('product_id', $id)->where('ip_address', $request->ip())->first();
       $product = Product::where('id', $id)->first();

       if($cartProduct == null){
        $cart = new Cart();
        $cart->product_id = $id;
        $cart->ip_address = $request->ip();
        $cart->qty = 1;
        if($product->discount_price !=null){
        $cart->price = $product->discount_price;
      }
      elseif($product->discount_price == null){
          $cart->price = $product->regular_price;
      }
      $cart->save();
          toastr()->success('Added to cart!');
          return redirect()->back();

       }
       elseif($cartProduct != null){
        $cartProduct->qty = $cartProduct->qty + 1;
        $cartProduct->save();
        toastr()->success('Added to cart!');
        return redirect()->back();
       }
    }

    public function deleteAddtoCart ($id)
    {
        $cartProduct = Cart::find($id);
        $cartProduct->delete();

       // toastr()->success('Removed from cart!');
        return redirect()->back();
    }

    //Confirm Order...
    public function confirmOrder (OrderRequest $request)
    {
        $order = new Order();

        $previousOrder = Order::orderBy('id', 'desc')->first(); //10

         if($previousOrder == null){
            $order->invoiceId = 'MOM-1';
         }

        if($previousOrder != null){
            $generateInvoiceId = 'MOM-'.$previousOrder->id+1;
            $order->invoiceId = $generateInvoiceId ; //MOM-11
        }

        $order->c_name = $request->c_name;
        $order->c_phone = $request->c_phone;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->area = $request->area;
        $order->price = $request->inputGrandTotal;


        //Store Info into OrderDetails Table...
        $cartProducts = Cart::with('product')->where('ip_address', $request->ip())->get();
        if($cartProducts->isNotEmpty()){
           $order->save();
           foreach($cartProducts as $cart){
            $orderDetails = new OrderDetails();

            $orderDetails->order_id = $order->id;
            $orderDetails->product_id = $cart->product_id;
            $orderDetails->qty = $cart->qty;
            $orderDetails->price = $cart->price;
            $orderDetails->size = $cart->size;
            $orderDetails->color = $cart->color;

            $orderDetails->save();

           }
       }

       else{
        toastr()->warning('No products in your cart!!');
        return redirect('/');
       }

       toastr()->success('Order is placed successfully!');
       return redirect('/');
    }
}
