<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'person';
    protected $fillable = ['name','type_document','num_document','direction','phone','email'];

    public function proveedor(){
        return $this->hasOne('App\Provider');
    }
}
