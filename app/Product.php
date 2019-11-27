<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;
use Auth;

class Product extends Model
{
    protected $table = 'products';
    //PROTEZIONE COLONNE
    protected $protected = ['id'];
    protected $fillable = ['name','category_id', 'imagepath', 'quantity', 'description','price','eliminated', 'onlyLink'];


    //QUERY SCOPE
    //Possiamo definire dei filtri standard all'interno dell'aplicativo usando le query scope.
    //Sono dei metodi particolari che agiscono da filtri che possono essere composti in sequenza
    //Una query scope deve chiamarsi "scope[nomeScope]" e quando la vogliamo usare si usa solo [nomeScope]
    public function scopeAvailable($query){
        return $query->where([ ['eliminated','=', 0], ['onlyLink','=',0] ]);   //ritorna un Builder e quindi posson essere applicate altre query scope o altri filtri
        //return $query->where('eliminated','=', 0)->get();                    //ritorna un Collection 
    }

    public function scopeNotAvailable($query){
        return $query->where('eliminated','=', 1);
    }

    public function scopeCategory($query, $categoryID) {
        return $query->where('category_id','=',$categoryID);
    }

    public function scopeOnlyLink($query) {
        return $query->where('onlyLink','=','1');
    }

    //GLOBAL SCOPE
    //A qualunque query sarà applicata questa query scope
    protected static function boot(){
        parent::boot();
    }


    //RELAZIONI ELOQUENT
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function orders(){
        return $this->belongsToMany(Order::class)->withPivot('orderedQuantity', 'purchasePrice');
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }
    

    //METODI
    public function eliminate() {
        $this->update(['eliminated' => 1]);

        //Elimina il prodotto da tutti i carrelli
        foreach ($this->cart()->withoutGlobalScope('current_user')->get() as $cart) {
            $this->addQuantity($cart->quantity);
            $cart->delete();
        }
    }

    public function addQuantity($number) {
        $this->quantity = $this->quantity + $number;
        $this->save();
    }
    public function removeQuantity($number) {
        $this->quantity = $this->quantity - $number;
        $this->save();
    }

    public function isElimitated() {
        if ($this->eliminated == 1){
            return true;
        }
        return false;
    }

    public function canBuy() {
        if ($this->eliminated == 0 && $this->quantity > 0 && !( Auth::check() && Auth::user()->isAdmin() ) ){
            return true;
        }
        return false;
    }

    public function costo(){
        $totale = 0;
        $totali = $this->orders()->withoutGlobalScopes()->select(DB::raw('orderedQuantity*purchasePrice as total'))->get('total');
        foreach ($totali as $itemTotali) {
            $totale = $totale + $itemTotali['total'];
        }
        return $totale;
    }

    public function totaliVenditeGiornaliere(){
        return $this->orders()->withoutGlobalScopes()->select(DB::raw('sum(orderedQuantity) as total, DATE(created_at) as day, YEAR(created_at) as Y, MONTH(created_at) as m, DAY(created_at) as d') )->groupBy('day')->get();
    }

    public function totaliGuadagniGiornalieri(){
        return $this->orders()->withoutGlobalScopes()->select(DB::raw('sum(orderedQuantity*purchasePrice) as total, DATE(created_at) as day, YEAR(created_at) as Y, MONTH(created_at) as m, DAY(created_at) as d') )->groupBy('day')->get();
    }
}
