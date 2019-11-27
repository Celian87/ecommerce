@extends('Product.show')

@section('link')
    @if ( Auth::user()->isAdmin() )
        <h5 class="bnt">
            <a href="/adminConsole">
                ADMIN CONSOLE
            </a>
            >
            <a href="{{ action("CategoryController@showNotAvailable",$product->category->id) }}">
                {{ $product->category->name}}
            </a>
        </h5>
    @endif
@endsection