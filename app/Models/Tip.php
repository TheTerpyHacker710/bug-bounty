<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    public static function getNext($user, $location)
    {
        $tip = Tip::whereUserId($user)->whereLocationTag($location)->whereReadAt(null)->orderBy('created_at')->first();
        if ($tip == null) return null;
        $tip->read_at = now();
        $tip->save();
        return $tip->content;
    }
}
