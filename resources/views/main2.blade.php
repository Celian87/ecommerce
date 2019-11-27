{{-- Home del sito --}}

@extends('layouts.app2')

@section('name-page')
    HOME
@endsection

@section('content')
    <!-- Product grid -->
    @foreach (App\Category::all() as $category)
        <div class="w3-padding w3-light-grey w3-small" style="background-color: #ff8b2b !important; border-radius: 5px;"><br>
            <h6 style="font-weight: bold; font-size: 1.3rem; color: #fff">{{ $category->name }}</h6>
            <h6 style="text-align: end; font-weight: bold;"><a style="color: #fff" href="{{ action('CategoryController@show', $category->id)}}">mostra altro >></a></h6>
        </div>
        <br>
        <div class="w3-row" style="text-align: center;">
            @foreach ($category->products()->available()->limit(4)->get() as $product)
                @include('Product.tile2', ['product' => $product, 'link' => action('ProductsController@show', $product->id)])
            @endforeach
        </div>
        <br><br>
    @endforeach
@endsection