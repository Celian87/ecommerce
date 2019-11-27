{{-- Pagina di edit della categoria--}}

@extends('layouts.app2')

@section('name-page')
    Edit category {{ $category->name }}
@endsection

@section('content')
    <div class="w3-padding w3-light-grey">
        <div class="card">
            <div class="card-body"><br>

                <form method="POST" action="{{ action('CategoryController@update', $category) }}">
                    @method('PATCH')
                    @csrf()

                    <div class="form-group col-md-3">
                        <label for="name"><strong>Name</strong></label>
                        <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                    </div>

                    <div class="form-group col-md-3">
                        <button type="submit" class="btn btn-primary">Update category</button>
                    </div>
                </form><br>
                
            </div>
        </div>
    </div>
@endsection