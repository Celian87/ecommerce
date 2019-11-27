
@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <h1>Edit category</h1>
                </div>
                <div class="card-body jumbotron">

                    <form method="POST" action="{{ action('CategoryController@store') }}">
                        @csrf()

                        <div class="form-group col-md-3">
                            <label for="name"><strong>Name</strong></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>

                        <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-primary">Crea</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection