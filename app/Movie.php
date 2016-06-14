<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //
    protected $fillable = ['id','title','title_long','year','rating','runtime','genre','synopsis','yt_trailer_code',
        'small_cover_image','large_cover_image'];
}
