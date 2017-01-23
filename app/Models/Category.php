<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    static public function cateList()
    {
        $cate = self::orderBy('id')->pluck('name', 'id');
        return $cate;
    }
}
