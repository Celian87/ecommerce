{{-- Pagin di visualizzazione del carrello dell'utente connesso --}}

@extends('layouts.app2')

@section('name-page')
    Il tuo carrello
@endsection

@section('content')
    <div class="w3-padding w3-light-grey" style="background-color: #ff8b2bad !important">
        <div class="card">
            @if ($cart->count()==0)
                <div class="card-header">
                    <h2>Il tuo carrello è vuoto.</h2>
                    <p>Il tuo carrello è vuoto.
                        Per aggiungere articoli al tuo carrello naviga su ZonkoShop.test,
                        quando trovi un articolo che ti interessa, clicca su "Aggiungi".
                    </p>
                </div>
            @else
                @php
                    $totale = 0.0;
                @endphp
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ( $cart as $item )
                            <div class="list-group-item" id="cart-{{ $item->id }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <span>
                                            <h4 class="mb-1">
                                                <a href="{{ action('ProductsController@show',$item->product->id) }}">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h4>

                                            @php
                                                $item_price = $item->quantity * $item->product->price;
                                                $totale += $item_price;
                                            @endphp

                                            Quantità
                                        
                                            <select name="quantity"
                                                    class="edit-quantity"
                                                    route="{{ action('CartController@update',$item->id) }}"
                                                    data-id="{{ $item->id }}"
                                            >
                                                @for ($i=1; $i <= ($item->product->quantity + $item->quantity); $i++)
                                                    <option value="{{ $i }}"
                                                        @if($item->quantity == $i)
                                                            selected
                                                        @endif
                                                    >{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </span>
                                    </span>
                                    </div>

                                    <div>
                                    <span class="h5">
                                        <span id="item-{{ $item->id }}-price">
                                            @php
                                                echo number_format( $item_price , 2, ',', '.');
                                            @endphp
                                        </span>
                                        <span>€</span>
                                    </span>

                                    <span>
                                        <a class="btn btn-danger remove-from-cart"
                                            href="{{ action('CartController@destroy',$item->id) }}"
                                            data-id={{ $item->id }}
                                        >
                                            <span>Rimuovi</span>
                                        </a>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <hr>
                        <div class="d-flex w-100 justify-content-between">
                            <div class="h3">Totale</div>
                            <h3>
                                <span id="totale">
                                    @php
                                        echo number_format( $totale, 2, ',', '.');
                                    @endphp
                                    €
                                </span>
                            </h3>
                        </div>

                        <div class="justify-content-end d-flex">
                            <form action="{{ action('OrdersController@store') }}" method="post">
                                @csrf()
                                <button type="submit" class="btn btn-warning">Completa Acquisto</button>
                            </form>
                        </div>
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection


@section('page-javascript')
<script>
    var JSONresponse;
$(document).ready(function(){
    //ELIMINA DAL CARRELLO
    $(".remove-from-cart").bind("click", function(event) {
        event.preventDefault(); //evita che la pagina cambi
        var cart_id = $(this).attr('data-id');

        //richiesta AJAX
        $.ajax({
            method: 'DELETE',
            dataType: "json",
            url: $(this).attr('href'),
            data: {
                //_token: document.getElementsByName("_token")[0].value, //CSRF
                //product_id: product_id
            },
            success: function(response){
                console.log(response); //stampa quello che ha restituito il controller

                //Elimino riga dal DOM
                $('#cart-'+cart_id).slideUp();

                //Aggiorno il totale
                console.log(response.total);
                $('#totale').text(''+response.total);
            },
            error: function(request, error) {
                console.log("AJAX error "+request.status+": "+request.statusText);
                //console.log(request); console.log(error);
            }
        });
    });

    //CAMBIA QUANTITA'
    $(".edit-quantity").bind("change", function(){
        //console.log($(this));
        //$(this).css("background-color", "#D6D6FF");
        var cart_id = $(this).attr("data-id")

        //Preparo la richiesta
        var data = {
            //_token: document.getElementsByName("_token")[0].value, //CSRF
            //product_id: $(this).attr("data-prodid"),
            quantity: $(this).val()
        };
        console.log( $(this).val() );
        console.log( $(this).attr('route') );

        //Richiesta AJAX
        $.ajax({
            method: 'PATCH',
            dataType: "json",
            url: $(this).attr('route'),
            data: data,
            success: function(response){
                //response = JSON.parse(response); //solo se non si usa datatype: "json"
                console.log(response); //stampa quello che ha restituito il controller
                console.log('sono entrato');

                //Aggiorno i valori a schermo
                $("#totale").text(""+response.total);
                $("#item-"+cart_id+"-price").text(""+response.newPrice);
            },
            error: function(request, error) {
                console.log("AJAX error "+request.status+": "+request.statusText);
                console.log('non sono entrato');
                console.log(request);
                console.log(error);
            }
        });
    });
});
</script>
@endsection
