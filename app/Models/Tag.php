<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    static public function tagList()
    {
        $tag = self::orderBy('id')->pluck('name', 'id');
        return $tag;
    }
}
