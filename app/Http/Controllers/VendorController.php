<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Auth;
use Inertia\Inertia;

class VendorController extends Controller
{

   public function vendorRequests() {
        //display all vendor requests (for admin)
   }

   public function vendorApply(){

       if(Auth::user()->isVendor == 0){
          
            $input= $request->toArray();
            $id = Auth::user()->id;

            
       }
       
   }

   public static function vendorDashboard(){

        if(Auth::user()->isVendor == 1){
             $vendorPrograms = Program::where('vendorID', Auth::user()->id)->get()->toArray();

            return Inertia::render('Vendor', [
                    'programs' =>  $vendorPrograms,
                ]);
       
        }else{
            return abort(403);
        }
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
