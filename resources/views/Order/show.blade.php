{{-- Mostra gli ordini dell'utente loggato --}}

@extends('layouts.app')


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <h3>I tuoi Ordini</h3>
                </div>

                <div class="card-body">

                    @foreach ($orders as $order)
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5>Ordine del {{ $order->created_at->format('d-m-Y') }}</h5>
                                    </div>
                                    <div class="col">
                                        <h5 align="right">
                                            # {{ $order->id }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    @php
                                        $totale = 0;
                                    @endphp
                                    @foreach ($order->products as $product)
                                        <li class="list-group-item">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <a href="{{ action('ProductsController@show',$product->id) }}">
                                                            <img src="{{ asset('images/product/'.$product->imagepath) }}" style="width:150px; height:150px;" align:center>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p class="titolo">
                                                            <a href="{{ action('ProductsController@show',$product->id) }}">
                                                                <b>{{ $product->name }}</b>
                                                            </a>
                                                        </p>
                                                        <p>
                                                            <span> Quantità comprata: {{ $product->pivot->orderedQuantity }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md">
                                                        <p align="right">
                                                            <span> Prezzo di acquisto: {{ $product->pivot->purchasePrice }}€</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @php
                                            $totale += $product->pivot->orderedQuantity * $product->pivot->purchasePrice;
                                        @endphp
                                    @endforeach
                                    <li class="list-group-item">
                                        <div class="h3" align="right">Totale
                                            <span id="totale">
                                                @php
                                                    echo number_format( $totale , 2, ',', '.');
                                                @endphp
                                                €
                                            </span>
                                        </div>
                                    </li>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>

            </div>
        </div>
    </div>
@endsection
