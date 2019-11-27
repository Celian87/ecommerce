
@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <h1>&nbsp Add new product</h1>
                </div>
                <div class="card-body jumbotron">

                    <form method="POST" action="{{ action('ProductsController@store') }}" enctype="multipart/form-data">
                        @csrf()

                        <div class="form-group">
                            <label for="name"> <strong> Name </strong> </label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <label for="price"><strong> Price </strong> </label>
                                <input type="number" name="price" class="form-control" value="{{ old('price') }}">
                            </div>
                            
                            <div class="col">
                                <label for="quantity"><strong> Quantity </strong></label>
                                <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="category_id"> <strong> Choose category </strong></label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            @foreach (App\Category::all() as $category)
                                                @if ( old('category_id') == $category->id )
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
                                        <input type="file" name="imagepath" class="custom-file-input">
                                        <label class="custom-file-label">Select file</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content"> <strong> Description </strong> </label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" name="onlyLink" value="1" class="form-check-input">
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
                            <button type="submit" class="btn btn-primary"><strong>Create</strong></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
