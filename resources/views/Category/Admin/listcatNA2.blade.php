
{{-- Visualizza tutti i prodotti della categoria e altre info, più la possibilità di modificare la categoria e aggiungere prodotti --}}

@extends('layouts.app2')

@section('name-page')
    {{ $category->name }}
@endsection

@section('content')
    <div class="w3-row w3-padding w3-light-grey">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        Disponibili: {{ $category->products()->available()->count() }}<br>
                        Eliminati: {{ $category->products()->notAvailable()->count() }}<br>
                        Disponibili tramite link: {{ $category->products()->onlyLink()->count() }}<br>
                    </div>

                    <div class="col-md-4">
                        <a class="bnt" href="{{ action('CategoryController@edit', $category->id) }}">
                            Edit categoty
                        </a><br>
                        <a href="{{ action('ProductsController@create') }}">
                            Inserisci un nuovo prodotto nel catalogo
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Id prodotto</th>
                            <th>Nome Prodotto</th>
                            <th>Stato</th>
                            <th class="text-center">Quantità disponibile</th>
                            <th class="text-center">Quantità venduta</th>
                            <th class="text-center">Prezzo attuale</th>
                            <th class="text-center">Guadagno Totale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($category->products as $product)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ action('ProductsController@showNA', $product->id) }}">
                                        {{ $product->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ action('ProductsController@showNA', $product->id) }}">
                                        {{ str_limit($product->name, $limit = 25, $end = '...') }}
                                    </a>
                                </td>
                                <td>
                                    @if ($product->eliminated == 0)
                                        <p>Disponibile</p>
                                    @else
                                        <p style="color:#ff0000;">Eliminato</p>
                                    @endif
                                    @if ($product->onlyLink == 1)
                                        <p style="color:#ffbf00;">Only link</p>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <p  @if ($product->quantity < 20)
                                            @if ($product->quantity < 10)
                                                {{ "style=color:#ff0000;" }}
                                            @else
                                                {{ "style=color:#ffbf00;" }}
                                            @endif
                                        @else
                                            {{ "style=color:#009933;" }}
                                        @endif
                                    >
                                        {{ $product->quantity }}
                                    </p>
                                </td>
                                <td class="text-center">
                                        {{ $product->orders()->withoutGlobalScopes()->count() * 
                                            $product->orders()->withoutGlobalScopes()->sum('orderedQuantity') }}
                                </td>
                                <td class="text-center">{{ $product->price }} €</td>
                                <td class="text-center">{{ $totalProduct = $product->costo() }} €</td>
                            </tr>
                            @php
                                $total += $totalProduct;
                            @endphp
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center"><b>TOTALE</b></td>
                            <td class="text-center">{{ $total }} €</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
