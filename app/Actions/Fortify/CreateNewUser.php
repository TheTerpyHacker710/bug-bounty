<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:30', 'unique:users'],
            'org_id' => ['required', 'string', 'max:8', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $new = User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'org_id' => $input['org_id'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $id = $new->id;
     
        for($i = 0; $i < count($input['user_tags']); $i++){

            Validator::make($input['user_tags'][$i], [
                'tag_id' => ['required', 'int', 'max:20']
            ])->validate();

            $tag = UserSkill::firstOrCreate([                     //firstorCreate checks database first to see if theres already a matching entry
                    'tag_id' => $input['user_tags'][$i]['tag_id'],
                    'user_id' => $id,
                    ]);
        }

        return $new;
    }
}
