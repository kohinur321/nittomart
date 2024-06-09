<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function showAllOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1 || Auth::user()->role ==2){
              $allOrders = Order::with('orderDetails')->get();

                return view('backend.admin.orders.allorders', compact('allOrders'));
            }
        }
    }

    public function showPendingOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1 || Auth::user()->role ==2){
              $pendingOrders = Order::with('orderDetails')->where('status', 'pending')->get();

                return view('backend.admin.orders.pendingorders', compact('pendingOrders'));
            }
        }
    }

    public function showConfirmedOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1 || Auth::user()->role ==2){
              $confirmedOrders = Order::with('orderDetails')->where('status', 'confirmed')->get();
                return view('backend.admin.orders.confirmedorders', compact('confirmedOrders'));
            }
        }
    }

    public function showDeliveredOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1 || Auth::user()->role ==2){
              $deliveredOrders = Order::with('orderDetails')->where('status', 'delivered')->get();
                return view('backend.admin.orders.deliveredorders', compact('deliveredOrders'));
            }
        }
    }

    public function showCancelledOrders ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1 || Auth::user()->role ==2){
              $cancelledOrders = Order::with('orderDetails')->where('status', 'cancelled')->get();
                return view('backend.admin.orders.cancelledorders', compact('cancelledOrders'));
            }
        }
    }
    public function statusCancelled ($id)
    {
        if(Auth::user()){
        if(Auth::user()->role ==1 || Auth::user()->role ==2){
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
        if(Auth::user()->role ==1 || Auth::user()->role ==2){
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
      if(Auth::user()->role ==1 || Auth::user()->role ==2){
        $order = Order::find($id);
       if($order->courier_name !=null){
        $order->status = 'delivered';

        if($order->courier_name == "steadfast"){
            $endPoint = "https://portal.steadfast.com.bd/api/v1/create_order";

            //Authentication Parameter...

            $apiKey = "pjj5c4td5dktrfkmdxx17sd4ykgl8g2f";
            $secretKey = "efkpccsphdsrjmyfzw0gtgsy";

            //The Body Parameters...
            $invoice = $order->invoiceId;
            $customerName = $order->c_name;
            $customerPhone = $order->c_phone;
            $customerAddress = $order->address;
            $price = $order->price;

            //The Header...
            $header = [
                'Api-Key' => $apiKey,
                'Secret-Key' => $secretKey,
                'Content-Type' => 'application/json'
            ];

            //The Payload...
            $payload = [
               'invoice' => $invoice,
               'recipient_name' => $customerName,
               'recipient_phone' => $customerPhone,
               'recipient_address' => $customerAddress,
               'cod_amount' => $price
            ];

           $response = Http::withHeaders($header)->post($endPoint, $payload);
           $responseData = $response->json();

        }

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
        if(Auth::user()->role ==1 || Auth::user()->role ==2){
          $order = Order::where('id', $id)->with('orderDetails')->first();
         return view('backend.admin.orders.details', compact('order'));
        }
    }
  }

  public function orderUpdate (Request $request, $id)
  {
    if(Auth::user()){
        if(Auth::user()->role ==1 || Auth::user()->role ==2){
             $order = Order::find($id);

             $order->c_name = $request->c_name;
             $order->c_phone = $request->c_phone;
             $order->email = $request->email;
             $order->address = $request->address;
             $order->price = $request->price;

             if(isset($request->courier_name)){
                if($request->courier_name == 'steadfast'){
                    $order->courier_name = 'steadfast';
                 }



                 if($request->courier_name == 'others'){
                    $order->courier_name = $request->others_courier;
                 }

                 //Send email to customer if email id is available

                 //Send email to customer if email id is available
         }

              $order->save();
              toastr()->success('Order is updated Successfully');
              return redirect()->back();

        }
     }
  }
}
