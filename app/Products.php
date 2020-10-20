<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'product_image', 'price', 'info','info_image','date', 'product_type_id'
    ];

    public function product_type()
    {
        return $this->belongsTo('App\ProductType');
        // Laravel在建立關係的時候,會以 "資料表名稱+_id"的欄位內容(product_type_id) 作為搜尋條件
    }

    public function productImgs()
    {
        return $this->hasMany('App\ProductImg','product_id');
    }
}
