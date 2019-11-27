{{-- Pagina di edit della categoria --}}

@extends('layouts.app2')

@section('name-page')
    Edit product
@endsection

@section('content')
    <div class="w3-padding w3-light-grey">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ action('ProductsController@update', $product->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf()

                    <div class="form-group">
                        <label for="name"><strong>Name</strong></label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label for="price"><strong>Price</strong></label>
                            <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                        </div>

                        <div class="col">
                            <label for="quantity"><strong>Quantity</strong></label>
                            <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="category_id"> <strong> Choose category </strong></label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach (App\Category::all() as $category)
                                            @if ( $product->category_id == $category->id )
                                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                            @else
                                                <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="col">
                            <div style="width:300px" class="form-group">
                                <label for="imagepath"> <strong> Image </strong></label>
                                <div class="custom-file">
                                <input type="file" name="imagepath" class="custom-file-input" value="{{ $product->imagepath }}">
                                <label class="custom-file-label"> {{ $product->imagepath }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content"><strong>Descripton</strong></label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ $product->description }}</textarea>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="onlyLink" value="1" class="form-check-input" @if ($product->onlyLink == 1){{ "checked" }} @endif>
                        <label class="form-check-label">access only via link</label>
                    </div>
                    <br>

                    <div class="form-check">
                        <input type="radio" name="eliminated" class="form-check-input" value="0">
                        <label class="form-check-label">
                            Purchase available
                        </label><br>
                        <input type="radio" name="eliminated" class="form-check-input" value="1" checked>
                        <label class="form-check-label">
                            Eliminates
                        </label>
                    </div>
                    <br>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><strong>Edit</strong></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection