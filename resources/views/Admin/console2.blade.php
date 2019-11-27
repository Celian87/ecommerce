{{-- Console admin fornisce info sulle categorie e sugli utenti con relativi link alle pagine delle categorie visibili agli admin e gli ordini degli utenti --}}

@extends('layouts.app2')

@section('name-page')
    ADMIN CONSOLE
@endsection

@section('content')
    <div class="w3-padding">
        <div class="card">
            <div class="card-body">
                <a href="{{ action('CategoryController@create') }}">Inserisci una nuova categoria</a><br>
                <a href="{{ action('ProductsController@create') }}">Inserisci un nuovo prodotto nel catalogo</a>
                <br><br>
                
                <h3>Categorie</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Id categoria</th>
                            <th>Nome categoria</th>
                            <th class="text-center">Prodotti disponibili</th>
                            <th class="text-center">Prodotti visibili tramite link</th>
                            <th class="text-center">Prodotti eliminati</th>
                            <th class="text-center">Totale prodotti</th>
                        </tr>
                    </thead>
                        @foreach (App\Category::all() as $category)
                            <tr>
                                <td class="text-center">{{ $category->id }}</td>
                                <td>
                                    <a class="btn" href="{{ action("CategoryController@showAll",$category->id) }}">
                                        {{ str_limit($category->name, $limit = 30, $end = '...') }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{ $category->products()->available()->count() }}
                                </td>
                                <td class="text-center">
                                    {{ $category->products()->onlyLink()->count() }}
                                </td>
                                <td class="text-center">
                                    {{ $category->products()->notAvailable()->count() }}
                                </td>
                                <td class="text-center">
                                    {{ $category->products()->count() }}
                                </td>
                            </tr>
                        @endforeach
                    <tbody>
                    </tbody>
                </table>
                <br><br>

                <h3>Utenti</h3>
                <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Id utente</th>
                                <th>Nome utente</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th class="text-center">Saldo</th>
                                <th class="text-center">Numero ordini</th>
                                <th class="text-center">Totale speso</th>
                                <th>Registrato dal</th>
                            </tr>
                        </thead>
                            @foreach (App\User::all() as $user)
                                <tr>
                                    <td class="text-center">{{ $user->id }}</td>
                                    <td>
                                        @if ( !$user->isAdmin() ) <a href="{{ action("OrdersController@indexAdmin", $user) }}"> @endif
                                            {{ str_limit($user->name, $limit = 15, $end = '...') }}
                                        @if ( !$user->isAdmin() ) </a> @endif
                                    </td>
                                    <td>
                                        {{ str_limit($user->email, $limit = 30, $end = '...') }}
                                    </td>
                                    <td>
                                        @if ( $user->isAdmin() )
                                            <p style=color:#009933;>Admin</p>
                                        @else
                                            Cliente
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ( !$user->isAdmin() )
                                            {{ $user->money }} €
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ( !$user->isAdmin() )
                                            {{ $user->orders()->withoutGlobalScopes()->count() }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ( !$user->isAdmin() )
                                            {{ DB::table('order_product')->join('orders','orders.id','=','order_product.order_id')->select( DB::raw('sum(orderedQuantity*purchasePrice) as total') )->where('user_id','=',$user->id)->first()->total }} €
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        <tbody>
                        </tbody>
                    </table>
                
            </div>
        </div>
    </div>
@endsection
