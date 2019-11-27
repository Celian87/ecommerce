{{-- Visualizza tutti i prodotti visibili per una categoria --}}

@extends('Product.list')

@section('countentList')
    {{-- mostra una tile per ogni prodotto --}}
    @forelse ($category->products()->available()->get() as $product)
        @include('Product.prodtile', ['product' => $product, 'link' => action('ProductsController@show', $product->id)] )
    @empty
        <p class="text">Al momento non ci sono prodotti disponibili in questa categoria</p>
    @endforelse
@endsection
