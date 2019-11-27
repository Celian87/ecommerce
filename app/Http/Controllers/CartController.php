<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\Product;

class CartController extends Controller
{

    public function index(){
        $cart = Cart::orderBy('updated_at', 'desc')->get();
        return view('Cart.show2', ['cart' => $cart]);
        return view('Cart.show', ['cart' => $cart]);
    }



    /*
        Usa AJAX per il Form
    */
    public function store(Request $request){
        $max = Product::where('id','=',request()->product_id)->first()['quantity'];
        $validated = request()->validate([
            'product_id' => 'bail | required | numeric | min:0',
            'quantity' => "bail | required | numeric | min:0 | max:$max",
        ]);

        $product = Product::find($validated['product_id']);
        if ( $product->cart->count() > 0 ) {
            if ( request()->ajax() ) {
                return json_encode([
                    "status" => "ERROR",
                    "statusText" => "Questo elemento è già stato inserito nel carrello"
                    ]);
            } else {
                return back(); //pagina precedente
            }
        }

        $cart = Cart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity']
        ]);

        $cart->product->removeQuantity($validated['quantity']);

        if ( request()->ajax() ) {
            return json_encode(["status" => "OK"]);
        } else {
            return back();
        }
    }



    /*
        Usa AJAX
    */
    public function update(Cart $cart, Request $request){
        $max = Product::where('id','=',$cart->product_id)->first()['quantity'];
        //Log::error("request = '. request()");
        request()->validate([
            'product_id' => 'numeric | min:0',
            'quantity' => "required | numeric | min:0 | max:$max"
        ]);

        if ( $cart->user_id != Auth::user()->id ) {
            return json_encode(["status" => "INVALIDAUTH", "message" => "La richiesta contiene un ID utente che non corrisponde a quello dell'utente attuale"]);
        }

        if ( request()->has('quantity') ) {
            $cart->product->removeQuantity( request()->quantity - $cart->quantity );
            $cart->update( ['quantity' => request()->quantity] );
        }

        $new_price = $cart->product->price * $cart->quantity;
        
        $total = 0.00;
        foreach( Cart::all() as $element ) {
            $total += $element->quantity * $element->product->price;
        }

        return json_encode([
            "status" => "OK",
            "newPrice" => number_format($new_price, 2, ',', '.'),
            "total" => number_format($total, 2, ',', '.')
        ]);
    }



    /*
        Usa AJAX
    */
    public function destroy(Cart $cart){
        if ( $cart->user_id != Auth::user()->id ) {
            return json_encode(["status" => "INVALIDAUTH", "message" => "La richiesta contiene un ID utente che non corrisponde a quello dell'utente attuale"]);
        }

        $cart->product->addQuantity($cart->quantity);
        $cart->delete();

        $total = 0.00;
        foreach( Cart::all() as $element ) {
            $total += $element->quantity * $element->product->price;
        }

        return json_encode([
            "status" => "OK",
            "statusText" => "Elemento rimosso correttamente dal carrello",
            "total" => number_format($total, 2, ',', '.')
        ]);
    }
}
