<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'place';

    protected $fillable = [
        'email', 'location', 'image_url', 'place_name','info'
    ];
}
