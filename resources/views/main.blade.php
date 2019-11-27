{{-- Pagina principale --}}

@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <br>
            
            @foreach (App\Category::all() as $category)
                <div class="card">
                    <div class="card-header">
                        <h3 class="subtitle">
                            {{ $category->name }}
                        </h3>
                        <h6>
                            <a href="{{ action('CategoryController@show', $category->id)}}">
                                Mostra altro >>
                            </a>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="card-deck">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($category->products()->available()->get() as $product)
                                @if ( $count < 4 )
                                    @include('Product.prodtile', ['product' => $product, 'link' => action('ProductsController@show', $product->id)])
                                @endif
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
