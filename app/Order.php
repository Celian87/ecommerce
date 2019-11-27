<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{

    //PROTEZIONE COLONNE
    protected $protected = ['id', 'user_id'];
    protected $fillable = ['status'];

    //QUERY SCOPE

    //GLOBAL SCOPE
    //A qualunque query sarà applicata questa query scope
    protected static function boot(){
        parent::boot();

        //Query scope
        //Può essere eventualmente disattivata
        static::addGlobalScope('current_user', function(Builder $builder)  {
            $builder->where('user_id', '=', Auth::user()->id);
        });
    }

    //RELAZIONI ELOQUENT
    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('orderedQuantity', 'purchasePrice');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    //METODI
}
