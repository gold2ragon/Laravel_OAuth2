<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    //
    protected $primaryKey = 'link';

    protected $fillable = [
        'name', 'address', 'latitude', 'longitude', 'duration', 'category', 'rating', 'rating_count', 'price', 'description', 'link', 'image_url'
    ];
}
