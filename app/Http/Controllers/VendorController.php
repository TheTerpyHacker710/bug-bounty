<?php

namespace App\Http\Controllers;

use App\Jobs\AssignVerifiers;
use Illuminate\Http\Request;
use App\Models\Program;
use Auth;
use Inertia\Inertia;
use App\Models\VendorRequest;
use App\Models\User;
use App\Models\Report;
use Redirect;

class VendorController extends Controller
{

   public function vendorRequests() {

        $data = VendorRequest::all();

       return Inertia::render('Admin/Dashboard', [
           'vendor_requests' => $data,
       ]);

   }

   public function vendorApprove(request $request){

        $request->validate([
           'user_id' => 'required',
        ]);

        VendorRequest::where('user_id', $request->user_id)->update(['approved' => 1]);
        User::where('id', $request->user_id)->update(['isVendor' => 1]);

        return Redirect::route('adminDashboard');

   }

   public function reportApprove(request $request){

       $request->validate([
               'id' => 'required|exists:reports',
            ]);

        $report = Report::find($request->id);

        $report->update(['vendorApproved' => 1]);

        AssignVerifiers::dispatch($report);

        return Redirect::route('Vendor');

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

     
        $vendorPrograms = Program::where('vendorID', Auth::user()->id)->get();
        $vendorReports = array();

        //Get all reports for every program that belongs to the current logged in vendor
        foreach($vendorPrograms as $program){

            $programReports = $program->reports()->get();
            $requiresVendorApproval = 0;

            if($program->vendorApproval == 1){
                $requiresVendorApproval = 1;
            }            

            foreach($programReports as $programReport){
                $programReport->setAttribute('requiresApproval', $requiresVendorApproval);
                array_push($vendorReports, $programReport);
            }        
        }

        $reports = array_reverse($vendorReports);

       //return print_r($vendorReports);
        
        return Inertia::render('Vendor', [
                'programs' =>  $vendorPrograms,
                'reports' => $reports,
            ]);
       
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

    public function programUpdate(Request $request){

         $request->validate([
            'id' => 'required',
           'title' => 'required',
           'vendorApprove' => 'required',
           'descr' => 'required',
        ]);

        Program::where('id', $request->id)->update(['Title' => $request->title, 'Description' => $request->descr, 'vendorApproval' => $request->vendorApprove]);

        return Redirect::route('Vendor');

    }


}
