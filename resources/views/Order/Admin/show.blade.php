{{-- Pagina di visualizzazione degli ordini di un utente da parte dell'adimin --}}

@extends('layouts.app2')

@section('name-page')
    @php
        $user = $orders[0]->users()->first();
    @endphp
    Ordini dell'utente {{ $user->name }}
@endsection

@section('content')
    <div class="w3-padding w3-light-grey">

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
@endsection
