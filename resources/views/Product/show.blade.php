{{-- Elenco informazioni sul SINGOLO prodotto --}}

@extends('layouts.app')

@section('head')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

@section('content')
    {{-- Mostra tutte le info sul prodotto qui --}}
    <div class="col-md-12">
        @yield('link')
        {{--<h5>
            <a class="bnt" href="/adminConsole">
                ADMIN CONSOLE
            </a>
            >
            <a class="bnt" href="{{ action("CategoryController@showNotAvailable",$product->category->id) }}">
                {{ $product->category->name}}
            </a>
        </h5>--}}
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">

                    <table class="prodotto_descr">
                        <tr>
                            <td style="width: 1px">
                                <img src="{{ asset('images/product/' . $product->imagepath) }}" style="width:300px; height:300px;" alt="imagepath" align:center>
                            </td>

                            <td style="padding-top:20; vertical-align: top">
                                <table>
                                    <tr><p class="titolo"><b><h4>{{ $product->name }}</h4></b></p></tr>
                                    @if ( $product->canBuy() )
                                        <tr><p><span>Prezzo: </span><span>{{ $product->price }} €</span></p></tr>
                                    @endif
                                    <tr><p class="prodotto_descr">{!! nl2br(e($product->description)) !!}</p></tr>

                                    <tr>
                                        <td>
                                            <form action="{{ action('CartController@store') }}" method="POST" >
                                                @csrf()

                                                @if ( Auth::check() ){{--Utente loggato--}}
                                                    @if( $product->canBuy() ){{--Prodotto disponibile, l'utente che accende non è l'admin--}}
                                                        {{--Utente normale--}}
                                                        <input type="text" name="product_id" value={{ $product->id }}  style=display:none></br>
                                                        Quantità
                                                        <select name="quantity">
                                                            @php
                                                                $item = $product->cart;
                                                                $item_in_cart = Auth::check() && !$item->isEmpty();
                                                            @endphp
                                                            @for ($i=1; $i<=$product->quantity; $i++)
                                                                <option value="{{$i}}"

                                                                @if($item_in_cart && $item[0]->quantity == $i)
                                                                    selected
                                                                @endif
                                                                >{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                        @if ($product->cart()->count() > 0){{--Controllo prodotto già aquistato--}}
                                                            <a class="btn btn-disabled" href="{{action('CartController@index')}}">
                                                                <span>€</span>
                                                                <span>Nel carrello</span>
                                                            </a>
                                                        @else
                                                            <button class="btn btn-warning add-to-cart" type="submit">
                                                                <span>€</span>
                                                                <span>Aggiungi al Carrello</span>
                                                            </a>
                                                        @endif
                                                    @else
                                                        @if ( Auth::user()->isAdmin() )
                                                            <div>Quantità disponibile {{$product->quantity}}</div><br>
                                                            <span>
                                                                <a class="btn small" href="{{ action('ProductsController@edit', $product->id) }}">
                                                                    {{--<i class="fas fa-edit"></i>--}}
                                                                    <button type="button" class="btn btn-warning">Edit</button>
                                                                </a>
                                                            </span>
                                                        @else
                                                            <div>Attualmente non disponibile</div>
                                                        @endif
                                                    @endif
                                                @else{{--Utente non loggato--}}
                                                    @if( $product->quantity < 1 || $product->isElimitated() )
                                                        <div>Attualmente non disponibile</div>
                                                    @else
                                                        <div>Quantità disponibile {{$product->quantity}}</div>
                                                        <div>Accedi col tuo account per acquistare</div>
                                                    @endif
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    @if ( Auth::check() && Auth::user()->isAdmin() )
                        <div id="chart_div" align="center"></div>
                        <div id="chart_div2" align="center"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-javascript')
<script>
    google.charts.load('current', {'packages':['corechart']});

    var plot = [
        @foreach ( $product->totaliVenditeGiornaliere() as $order )
            [ new Date({{ $order->Y }}, 
                        {{ $order->m - 1 }}, 
                        {{ $order->d }}), 
            {{ $order->total }}],
        @endforeach
    ];
    google.charts.setOnLoadCallback(function () {drawChart(plot, 'chart_div', 'Vendite giornaliere', 'numero pezzi venduti');});


    var plot2 = [
        @foreach ( $product->totaliGuadagniGiornalieri() as $order )
            [ new Date({{ $order->Y }}, 
                        {{ $order->m - 1 }}, 
                        {{ $order->d }}), 
            {{ $order->total }}],
        @endforeach
    ];
    google.charts.setOnLoadCallback(function () {drawChart(plot2, 'chart_div2', 'Guadagni giornalieri', '€ guadagnati');});

    function drawChart(plot, idDiv, titleChart, assey) {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Time of Day');
        data.addColumn('number', assey);

        data.addRows( plot );

        var options = {
                        title: titleChart,
                        width: 800,
                        height: 400,
                        hAxis: {
                                format: 'M/d/yy',
                                gridlines: {count: 15}
                        },
                        vAxis: {
                                gridlines: {color: 'none'},
                                minValue: 0
                        }
        };

        var chart = new google.visualization.LineChart(document.getElementById(idDiv));
        chart.draw(data, options);

        //options.hAxis.format === 'M/d/yy' ?
        //options.hAxis.format = 'MMM dd, yyyy' :
        //options.hAxis.format = 'M/d/yy';
        options.hAxis.format = 'd/M/Y';

        chart.draw(data, options);
    }
</script>
@endsection