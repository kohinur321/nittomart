<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login ()
    {
        return view ('backend.login');
    }

    public function loginCheck (Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if(Auth::attempt(['email'=>$email, 'password'=>$password, 'role'=>1])){
            return redirect ('/admin/dashboard');
        }

        if(Auth::attempt(['email'=>$email, 'password'=>$password, 'role'=>2])){
            return redirect ('/admin/dashboard');
        }

        else{
            return redirect()->back();
         }
     }

        public function dashboard()
        {
            if(Auth::user()){
                if(Auth::user()->role ==1 || Auth::user()->role ==2){
                    $todayDate = Carbon::today();
                    $totalOrders = Order::count();
                    $todayOrders = Order::whereDate('created_at', $todayDate)->count();
                    $pendingOrders = Order::where('status', 'pending')->count();
                    $cancelledOrders = Order::where('status', 'cancelled')->count();
                    $deliveredOrders = Order::where('status', 'delivered')->count();
                    return view ('backend.admin.dashboard', compact('totalOrders', 'todayOrders', 'pendingOrders', 'cancelledOrders', 'deliveredOrders'));
                }
            }

            else{
                return redirect('/admin/login');
            }
        }
            public function employeeList()
            {
              if(Auth::user()){
                if(Auth::user()->role ==1){
                    $employees = User::where('role', 2)->get();
                    return view('backend.admin.employee.list', compact('employees'));
                }
              }
            }

            public function employeeCreate ()
            {
                if(Auth::user()){
                    if(Auth::user()->role ==1){
                        return view('backend.admin.employee.create');
            }
        }
    }

    public function employeeStore (Request $request)
            {
                if(Auth::user()){
                    if(Auth::user()->role ==1){
                       $employee = new User();

                       if(isset($request->image)){
                        $imageName = rand().'-user-'.'.'.$request->image->extension();
                        $request->image->move('backend/images/user/' ,$imageName);

                        $employee->image = $imageName;
                   }

                       $employee->name = $request->name;
                       $employee->phone = $request->phone;
                       $employee->email = $request->email;
                       $employee->password = $request->password;
                       $employee->address = $request->address;
                       $employee->role = 2;

                       $employee->save();
                       toastr()->success("New Employee Account has been Created");
                       return redirect('admin/employee-list');
            }
        }
    }
}
