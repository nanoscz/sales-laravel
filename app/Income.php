<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    // protected $primaryKey = 'id';
    protected $table = 'income';
    protected $fillable = [
        'id_provider',
        'id_user',
        'type_voucher',
        'series_voucher',
        'num_voucher',
        'date',
        'fax',
        'total',
        'state'
    ];

    public function user(){
        return $this->belogsTo('App\User');
    }

    public function provider(){
        return $this->belogsTo('App\Provider');
    }
}
