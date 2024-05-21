<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function showSettings ()
    {
        if(Auth::user()){
            if(Auth::user()->role ==1){
                $settings = Setting::first();
                return view ('backend.admin.settings', compact('settings'));
            }
        }
    }

    public function updateSettings (Request $request)
   {
    if(Auth::user()){
        if(Auth::user()->role ==1){
            $settings = Setting::first();

            if(isset($request->logo)){
                if($settings->logo && file_exists('backend/images/settings/'.$settings->logo)){
                    unlink('backend/images/settings/'.$settings->logo);
                }
             $imageName = rand().'-logo-'.'.'.$request->logo->extension();
             $request->logo->move('backend/images/settings/',$imageName);

             $settings->logo = $imageName;

            }

            $settings->phone = $request->phone;
            $settings->email = $request->email;
            $settings->address = $request->address;
            $settings->facebook = $request->facebook;
            $settings->twitter = $request->twitter;
            $settings->instagram = $request->instagram;
            $settings->youtube = $request->youtube;

            $settings->save();
             toastr()->success('Updated Successfully!');
             return redirect()->back();
        }
     }
  }
}
