<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news'; //此Model保護指定的資料表

    protected $fillable = [
        'title', 'sub_title', 'content', 'image_url'
    ];
    // $fillable = 可被寫入的欄位

    // $hidden = 資料不能被拿出來的欄位
}
