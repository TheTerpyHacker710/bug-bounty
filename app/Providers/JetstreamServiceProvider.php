<?php

namespace App\Providers;

use Auth;
use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use App\Models\UserSkill;
use App\Models\SkillTag;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
     public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);


        //When rendering profile information (default jetstream boilerplate)
        
        Jetstream::inertia()->whenRendering(
        'Profile/Show',
        function (Request $request, array $data){

                $usertags = UserSkill::where('user_id', Auth::user()->id)
                    ->leftJoin('skill_tags', 'user_skills.tag_id', '=', 'skill_tags.tag_id')
                    ->select('user_skills.tag_id', 'skill_tags.tag_name')->get()->values()->toArray();   //values used to reindex array to start at 0
                    
                $allskill = SkillTag::all()->toArray();
                $fullArr = ["user_tags" => $usertags, "skilltags" => $allskill];
                $all = array_merge($data, $fullArr);
                return $all;
                
            }
        );
        
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
