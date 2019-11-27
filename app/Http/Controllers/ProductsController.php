<?php

namespace App\Http\Controllers;

use App\Product;
use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    public function create(){
        if ( Auth::user()->isAdmin() ){
            return view('Product.Admin.create2');
            return view('Product.Admin.create');
        }
        return redirect('/');
    }



    public function store(Request $request){
        //$product = new Product();
        if ( Auth::user()->isAdmin() ){
            $validated = request()->validate([
                "name" => "required | min:3",
                "category_id" => "required | numeric | min:1",
                "imagepath" => "required",
                "description" => "required | min: 5",
                "price" => "required | numeric | min:0 | max:999999999",
                "quantity" => "required | numeric | min:0 | max:999999999",
            ]);
            
            if($request->hasFile('imagepath')){
                $file = $request->file('imagepath');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/product/', $filename);
                $validated['imagepath']=$filename;
            }else{
                $validated['imagepath']='image.jpg';
            }

            if( request('eliminated') ){
                $validated['eliminated'] = 1;
            }else{
                $validated['eliminated'] = 0;
            }

            if( empty( $request['onlyLink'] ) && $request['onlyLink'] != 1 ){
                $validated['onlyLink'] = 0;
            }else{
                $validated['onlyLink'] = 1;
            }

            $product = Product::create($validated);
            return redirect('product/'.$product->id);
        }
        return redirect('/');
    }


    public function show(Product $product){
        if ( $product->isElimitated() ) {
            if (  Auth::check() && $product->orders()->count() > 0 ) {
                return view('Product.show2', ['product' => $product]);
                return view('Product.showU', ['product' => $product]);
            }
            if ( $product->onlyLink ) {
                return view('Product.show2', ['product' => $product]);
                return view('Product.showU', ['product' => $product]);
            }
            if ( Auth::check() && Auth::user()->isAdmin() ){
                return view('Product.show2', ['product' => $product]);
                return view('Product.Admin.showA', ['product' => $product]);
            }
            return redirect('/');
        }
        return view('Product.show2', ['product' => $product]);
        return view('Product.showU', ['product' => $product]);
    }


    public function showNA(Product $product){
        if ( Auth::user()->isAdmin() ){
            return view('Product.show2', ['product' => $product]);
            return view('Product.Admin.showA', ['product' => $product]);
        }
        return redirect('/');
    }


    public function edit(Product $product){
        if ( Auth::user()->isAdmin() ){
            return view('Product.Admin.edit2', ['product' => $product]);
            return view('Product.Admin.edit', ['product' => $product]);
        }
        return redirect('/');
    }



    public function update(Request $request, Product $product){
        if ( Auth::user()->isAdmin() ){
            $validated = request()->validate([
                "name" => "required | min:3",
                "category_id" => "required | numeric | min:1",
                "description" => "required | min: 5",
                "price" => "required | numeric | min:0 | max:999999999",
                "quantity" => "required | numeric | min:0 | max:999999999"
            ]);
            
            if($request->hasFile('imagepath')){
                //se l'immagine che carico è diversa dalla precedente, la sostituisce
                if($request->imagepath != $product->imagepath){
                    $file = $request->file('imagepath');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/product/', $filename);
                    $validated['imagepath']=$filename;
                }
            }else{
                //nel caso in cui non modifico l'immagine, mi restituisce quella precedente
                $validated['imagepath']=$product->imagepath;
            }

            if( request('eliminated') ){
                $validated['eliminated'] = 1;
                $product->eliminate();
            }else{
                $validated['eliminated'] = 0;
            }

            if( empty( $request['onlyLink'] ) && $request['onlyLink'] != 1 ){
                $validated['onlyLink'] = 0;
            }else{
                $validated['onlyLink'] = 1;
            }

            $product->update($validated);
            return redirect('product/'.$product->id);
        }
        return redirect('/');
    }

    public function search(Request $request) {
        Log::info($request->all());
        $data = $request->validate([
            'name' => 'required'
        ]);

        //prende tutti i prodotti che contengono la stringa di ricerca
        if (Auth::check() && Auth::user()->isAdmin()) {
            $items = Product::where('name', 'LIKE', '%'.$data['name'].'%');
        }
        else { //i clienti non vedono prodotti che non possono acquistare
            $items = Product::available()->where('name', 'LIKE', '%'.$data['name'].'%');
        }

        //Preparo i dati da passare alla vista
        $search = [
            'results' => $items->get(),
            'text' => $request['name']
        ];
        //return $search; //TEST JSON
        return view('Product.search', ['search' => $search]);

    }

}
