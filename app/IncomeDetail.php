<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeDetail extends Model
{
    protected $table = 'income_detail';
    protected $fillable = [
        'id_income',
        'id_article',
        'quantity',
        'price'
    ];
    public $timestamps = false;
    public function user(){
        return $this->belogsTo('App\User');
    }
}
