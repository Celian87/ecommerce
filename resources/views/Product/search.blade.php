{{-- Pagina risultati ricerca --}}

@extends('layouts.app2')

@section('name-page')
    Search "{{$search['text']}}"
@endsection

@section('content')
    <div class="w3-row w3-padding" style="background-color: #ff8b2bad !important">
        <div class="card">
            <div class="card-body">
                <div class="w3-row">
                    @forelse ($search['results'] as $product)
                        @include('Product.tile2', ['product' => $product, 'link' => action('ProductsController@show', $product->id)])
                    @empty
                    <div class="card-body card-text">
                        <p>Nessun prodotto trovato per: "{{$search['text']}}"</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection