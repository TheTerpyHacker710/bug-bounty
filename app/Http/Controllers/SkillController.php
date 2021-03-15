<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use App\Models\SkillTag;
use App\Models\UserSkill;
use Inertia\Inertia;

class SkillController extends Controller
{

    public function show(){
    
    }

    
    public function store(Request $request){

    }

    public function update(Request $request){

        $input= $request->toArray();
        $id = Auth::user()->id;

        UserSkill::where('user_id', $id)->delete();

        for($i = 0; $i < count($input['new_tags']); $i++){

        Validator::make($input['new_tags'][$i], [
            'tag_id' => ['required', 'int', 'max:20']
        ])->validate();

        $tag = UserSkill::firstOrCreate([                     
                'tag_id' => $input['new_tags'][$i]['tag_id'],
                'user_id' => $id,
                ]);

        }

        return Inertia::render('user/profile');
    }
    
}
