{{-- Visualizza tutti i prodotti passati--}}

@extends('layouts.app')

@section('content')

    @yield('link')

    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $category->name }}</h3>
                    @yield('cardHeader')
                </div>
                <div class="card-body">
                    <div class="card-deck justify-content-around">
                        {{-- mostra una tile per ogni prodotto --}}

                        @yield('countentList')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
