{{-- Visualizza tutti i prodotti della categoria --}}

@extends('layouts.app2')

@section('name-page')
    {{ $category->name }}
@endsection

@section('content')

    <div class="w3-row w3-padding" style="background-color: #ff8b2bad !important">
        <div class="card">
            <div class="card-body">
                <div class="w3-row">
                    {{-- mostra una tile per ogni prodotto --}}
                    @forelse ($category->products()->available()->get() as $product)
                        @include('Product.tile2', ['product' => $product, 'link' => action('ProductsController@show', $product->id)] )
                    @empty
                        <p class="text">Al momento non ci sono prodotti disponibili in questa categoria</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection