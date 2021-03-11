<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillTag extends Model
{
    use HasFactory;

    protected $primaryKey = 'tag_id';

    //Whitelist since these can be mass-assignable without any issues
    protected $fillable = [
        'tag_name',
        'tag_descr',
    ];

    //Default values go here
    protected $attributes = [
        'tag_name' => 'default_tag',
        'tag_descr' => 'default_tag_descr',

    ];
}
