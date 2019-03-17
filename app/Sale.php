<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $fillable = [
        'id_client',
        'id_user',
        'type_voucher',
        'series_voucher',
        'num_voucher',
        'date',
        'tax',
        'total',
        'state'
    ];

    // public function user(){
    //     return $this->belogsTo('App\User');
    // }

    // public function provider(){
    //     return $this->belogsTo('App\Person');
    // }
}
