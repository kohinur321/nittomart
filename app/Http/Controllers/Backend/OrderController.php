<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showAllOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1){
              $allOrders = Order::with('orderDetails')->get();

                return view('backend.admin.orders.allorders', compact('allOrders'));
            }
        }
    }

    public function showPendingOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1){
              $pendingOrders = Order::with('orderDetails')->where('status', 'pending')->get();

                return view('backend.admin.orders.pendingorders', compact('pendingOrders'));
            }
        }
    }

    public function showConfirmedOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1){
              $confirmedOrders = Order::with('orderDetails')->where('status', 'confirmed')->get();
                return view('backend.admin.orders.confirmedorders', compact('confirmedOrders'));
            }
        }
    }

    public function showDeliveredOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1){
              $deliveredOrders = Order::with('orderDetails')->where('status', 'delivered')->get();
                return view('backend.admin.orders.deliveredorders', compact('deliveredOrders'));
            }
        }
    }

    public function showCancelledOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1){
              $cancelledOrders = Order::with('orderDetails')->where('status', 'cancelled')->get();
                return view('backend.admin.orders.cancelledorders', compact('cancelledOrders'));
            }
        }
    }
    public function statusCancelled ($id)
    {
        if(Auth::user()){
        if(Auth::user()->role ==1){
              $order = Order::find($id);
              $order->status = 'cancelled';

              $order->save();
              toastr()->success('Order has been cancelled!');
              return redirect()->back();
        }

     }
  }

    public function statusConfirmed ($id)
    {
        if(Auth::user()){
        if(Auth::user()->role ==1){
              $order = Order::find($id);
              $order->status = 'confirmed';

              $order->save();
              toastr()->success('Order has been confirmed!');
              return redirect()->back();
        }

     }
  }
  public function statusDelivered ($id)
  {
      if(Auth::user()){
      if(Auth::user()->role ==1){
        $order = Order::find($id);
       if($order->courier_name !=null){
        $order->status = 'confirmed';

        $order->save();
        toastr()->success('Order has been confirmed!');
              return redirect()->back();
       }

       else{
        toastr()->error('Courier is not selected yet!');
        return redirect()->back();
       }
      }
    }
  }

  public function orderDetails ($id)
  {
    if(Auth::user()){
        if(Auth::user()->role ==1){
          $order = Order::where('id', $id)->with('orderDetails')->first();
         // dd($order);
          return view('backend.admin.orders.details', compact('order'));
        }
    }
  }
}
