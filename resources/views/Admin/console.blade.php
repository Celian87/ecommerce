@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <h1>ADMIN CONSOLE</h1>
                </div>
                <div class="card-body">
                    <a href="{{ action('CategoryController@create') }}">Inserisci una nuova categoria</a><br>
                    <a href="{{ action('ProductsController@create') }}">Inserisci un nuovo prodotto nel catalogo</a>
                    <br><br>
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id categoria</th>
                                <th>Nome categoria</th>
                                <th class="text-center">Prodotti disponibili</th>
                                <th class="text-center">Prodotti eliminati</th>
                                <th class="text-center">Totale prodotti</th>
                            </tr>
                        </thead>
                            @foreach (App\Category::all() as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        <a class="btn" href="{{ action("CategoryController@showNotAvailable",$category->id) }}">
                                            {{ $category->name }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{ $category->products()->available()->count() }}
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
                    
                </div>
            </div>
        </div>
    </div>
@endsection
