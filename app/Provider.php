<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'provider';
    protected $fillable = ['id','contact','contact_phone'];
    public $timestamp = false;

    public function person(){
        return $this->belongsTo('App\Person');
    }
}
