<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\UserTag;
use Inertia\Inertia;

class SkillController extends Controller
{

    //Function for the controller to access
    public function show(){

        $tags = Tag::all();
        
        return Inertia::render('SkillTag', [
            'tags' => $tags
        ]);              
    }

    
    public function store(Request $request){

        $params = true; //for while loop - if we still have something in the request.
        
        $i = 0; //to iterate through request - some issues with for loops count
        while($params){

            if($request[$i] == NULL){   //if request is empty
                $params = false;        //exit while
            }else{

                $tag = UserTag::firstOrCreate([                     //firstorCreate checks database first to see if theres already a matching entry
                    'tag_id' => $request[$i]['tag_id'],
                    'user_id' => Auth::user()->id,
                    ]);
            
                $i++;
            }
                           
        }

        return Inertia::render('Dashboard');

    }
    
}
