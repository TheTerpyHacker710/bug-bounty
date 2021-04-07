<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Auth;
use Inertia\Inertia;
use App\Models\VendorRequest;

class VendorController extends Controller
{

   public function vendorRequests(request $request) {
       
        $request->validate([
           'user_id' => 'required',
        ]);

        VendorRequest::where('user_id', $request->user_id)->update(['approved' => 1]);
        User::where('id', $request->user_id)->update(['isVendor' => 1]);

        return Redirect::route('adminDashboard');
   }

   public function vendorApply(){
        
       if(Auth::user()->isVendor == 0){

            $id = Auth::user()->id;

             $tag = VendorRequest::firstOrCreate([                     
                'user_id' => $id,
                'approved' => '0'
                ]);

             return redirect()->route('dashboard');
        }   
       //else do nothing
       
   }

   public static function vendorDashboard(){

     
        $vendorPrograms = Program::where('vendorID', Auth::user()->id)->get()->toArray();

        return Inertia::render('Vendor', [
                'programs' =>  $vendorPrograms,
            ]);
        //Get all programs where program creator ID = current user ID
       
    }

    public function programDelete(Request $request){

        $input= $request->toArray();
        $id = Auth::user()->id;
        

        Program::where([
            'vendorID' => $id,
            'id' => $input['id']
            ])->delete();

        return redirect()->route('Vendor');
    }



}
