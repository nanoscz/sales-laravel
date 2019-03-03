<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // protected $primaryKey = 'id';
    protected $table = 'category';
    protected $fillable = ['name','description','status'];

    public function articles() {
        return $this->hasMany('App\Article');
    }
}
