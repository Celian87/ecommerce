{{-- Visualizza tutti i prodotti che non sonon visibili per una categoria --}}
{{--
@extends('Product.list')

@section('link')
    <a class="bnt" href="/adminConsole">
        ADMIN CONSOLE
    </a>
@endsection

@section('cardHeader')
    <a class="bnt" href="{{ action('CategoryController@edit', $category->id) }}">
        Edit categoty
    </a>
@endsection

@section('countentList')
    {{-- mostra una tile per ogni prodotto -}}
    @forelse ($category->products()->notAvailable()->get() as $product)
        @include('Product.prodtile', ['product' => $product, 'link' => action('ProductsController@showNA', $product->id)])
    @empty
        <p class="text">Al momento non ci sono prodotti disponibili in questa categoria</p>
    @endforelse
@endsection
--}}

@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <h5 class="bnt">
        <a href="/adminConsole">
            ADMIN CONSOLE
        </a>
    </h5>
    <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <h3>{{ $category->name }}</h3>
                                <a class="bnt" href="{{ action('CategoryController@edit', $category->id) }}">
                                    Edit categoty
                                </a>
                            </div>
                            <div class="col-md-3">
                                Disponibili: {{ $category->products()->available()->count() }}<br>
                                Eliminati: {{ $category->products()->notAvailable()->count() }}<br>
                                <a href="{{ action('ProductsController@create') }}">Inserisci un nuovo prodotto nel catalogo</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id prodotto</th>
                                    <th>Nome Prodotto</th>
                                    <th>Stato</th>
                                    <th>Quantità disponibile</th>
                                    <th>Quantità venduta</th>
                                    <th>Prezzo attuale</th>
                                    <th>Guadagno Totale</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($category->products as $product)
                                    <tr>
                                        <td>
                                            <a href="{{ action('ProductsController@showNA', $product->id) }}">
                                                {{ $product->id }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ action('ProductsController@showNA', $product->id) }}">
                                                {{ $product->name }}
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
    </div>
</div>
@endsection
