<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{

    //PROTEZIONE COLONNE
    protected $protected = ['id'];
    protected $fillable = ['name'];

    //QUERY SCOPE

    //GLOBAL SCOPE
    protected static function boot(){
        parent::boot();
    }

    //RELAZIONI ELOQUENT
    public function products(){
        return $this->hasMany(Product::class);
    }

    //METODI
}
