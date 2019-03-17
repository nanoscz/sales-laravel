<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sales_detail';
    protected $fillable = [
        'id_sale',
        'id_article',
        'quantity',
        'price',
        'discount'
    ];
    public $timestamps = false;
    // public function user(){
    //     return $this->belogsTo('App\User');
    // }
}
