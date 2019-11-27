<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\Cart;
use App\User;

class OrdersController extends Controller
{

    public function index() {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('Order.show2', ['orders' => $orders]);
        return view('Order.show', ['orders' => $orders]);
    }

    
    public function indexAdmin(User $user) {
        if ( Auth::user()->isAdmin() ){
            $orders = $user->orders()->withoutGlobalScopes()->orderBy('created_at', 'desc')->get();
            return view('Order.Admin.show', ['orders' => $orders]);
        }
        return redirect('/');
    }


    public function store(Request $request) {
        $carts = Cart::all(); //tutto quello che sta nel carrello
        //filtrato in automatico solo sull'utente loggato perchè c'è il 
        //global scope che filtra solo sull'untente loggato

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->status = 'In corso';
        $order->save();

        $costo = 0.0;
        //iteriamo sul carrello
        foreach ($carts as $cart) {
            $costo += $cart->quantity * $cart->product->price;
            $order->products()->attach($cart->product_id, ['orderedQuantity' => $cart->quantity, 'purchasePrice' => $cart->product->price]);
            $cart->delete();
        }

        //scalo i soldi dall'utente
        Auth::user()->money -= $costo;
        Auth::user()->update();

        return redirect(action('OrdersController@index'));
    }
    
}
