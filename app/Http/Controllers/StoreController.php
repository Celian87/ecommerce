<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use Log;


class StoreController extends Controller
{

    public function home() {
        $products = Product::all();
        return view('main2');
    }

    public function adminconsole() {
        if ( Auth::user()->isAdmin() ){
            return view('Admin.console2');
        }
        return redirect('/');
    }
}
