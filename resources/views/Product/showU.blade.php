@extends('Product.show')

@section('link')
    <h5 class="bnt">
        <a href="/">
            HOME
        </a>
        >
        <a href="{{ action("CategoryController@show",$product->category->id) }}">
            {{ $product->category->name }}
        </a>
    </h5>
@endsection