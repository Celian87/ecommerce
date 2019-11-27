{{-- Presentazione del prodotto, acquisto per i clienti o visualizzazione grafici per admin --}}

@extends('layouts.app2')

@section('head')
    @if ( Auth::check() && Auth::user()->isAdmin()  )
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    @endif
@endsection

@section('name-page')
    @if ( Auth::check() && Auth::user()->isAdmin() )
        <a href="{{ action("CategoryController@showAll",$product->category->id) }}">
            {{ $product->category->name}}
        </a>
    @else
        <a href="{{ action("CategoryController@show",$product->category->id) }}">
            {{ $product->category->name }}
        </a>
    @endif
@endsection

@section('content')
    {{-- Mostra tutte le info sul prodotto qui --}}
    <div class="w3-padding w3-light-grey" style="background-color: #ff8b2bad !important">
        <div class="card">
            <div class="card-body">

                <table class="prodotto_descr">
                    <tr>
                        <td style="width: 230px; padding: 10px">
                            <img src="{{ asset('images/product/' . $product->imagepath) }}" style="width:100%;" alt="imagepath" align:center>
                        </td>

                        <td style="padding-top:20; vertical-align: top">
                            <table>
                                <tr><p class="titolo"><b><h3>{{ $product->name }}</h3></b></p></tr>
                                
                                <tr><br><p class="prodotto_descr h5">{!! nl2br(e($product->description)) !!}</p></tr><br>
                                @if ( !$product->isElimitated() )
                                    <tr><br><br><p class="h5">Prezzo: {{ $product->price }} €</p></tr>
                                @endif

                                <tr><td>
                                    <form action="{{ action('CartController@store') }}" method="POST">
                                        @csrf()

                                        @if ( Auth::check() ){{--Utente loggato--}}
                                            @if( $product->canBuy() ){{--Prodotto disponibile, l'utente che accende non è l'admin--}}
                                                {{--Utente normale--}}
                                                <input type="text" name="product_id" value={{ $product->id }}  style=display:none></br>
                                                <p class="h5">Quantità
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
                                                </p><br>
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
                                                    <div class="h5">Quantità disponibile {{$product->quantity}}</div><br>
                                                    <a href="{{ action('ProductsController@edit', $product->id) }}">
                                                        {{--<i class="fas fa-edit"></i>--}}
                                                        <button type="button" class="btn btn-warning">Edit</button>
                                                    </a>
                                                @else
                                                    <div>Attualmente non disponibile</div>
                                                @endif
                                            @endif
                                        @else{{--Utente non loggato--}}
                                            @if( $product->quantity < 1 || $product->isElimitated() )
                                                <div class="h5">Attualmente non disponibile</div>
                                            @else
                                                <div class="h5">Quantità disponibile {{$product->quantity}}</div><br>
                                                <div class="h5">Accedi col tuo account per acquistare</div>
                                            @endif
                                        @endif
                                    </form>
                                </td></tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div>
        </div>

        @if ( Auth::check() && Auth::user()->isAdmin() )
            <br>
            <div id="chart_div" align="center"></div>
            <div id="chart_div2" align="center"></div>
            <br>
        @endif

    </div>

    @if ( !( Auth::check() && Auth::user()->isAdmin() ) )
        <br><br><br>
        <div class="w3-padding w3-small" style="background-color: #ff8b2b !important; border-radius: 5px;"><br>
            <h6 style="font-weight: bold; font-size: 1.3rem; color: #fff">{{ $product->category->name }}</h6>
            <h6 style="text-align: end; font-weight: bold;"><a style="color: #fff" href="{{ action('CategoryController@show', $product->category->id)}}">mostra altro >></a></h6>
        </div>
        <br>
        <div class="w3-row" style="text-align: center;">
            @foreach ($product->category->products()->available()->where('products.id','!=',$product->id)->limit(4)->get() as $productTemp)
                @include('Product.tile2', ['product' => $productTemp, 'link' => action('ProductsController@show', $productTemp->id)])
            @endforeach
        </div>
    @endif

@endsection

@section('page-javascript')
    @if ( Auth::check() && Auth::user()->isAdmin() )
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
    @endif
@endsection