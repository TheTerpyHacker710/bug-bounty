<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;

    public $timestamps = false;

    //Whitelist since these can be mass-assignable without any issues
    protected $fillable = [
        'user_id',
        'tag_id',
    ];

    //default values
   
}
