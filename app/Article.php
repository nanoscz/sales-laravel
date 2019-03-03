<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    protected $fillable = ['id_category','code','name','price', 'stock','description','state'];

    public function category() {
        return $this->belongsTo('App\Category');
    }
}