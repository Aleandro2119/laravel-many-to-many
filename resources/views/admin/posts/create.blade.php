@extends('layouts.app')

@section('content')
    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Aggiungi un Post</h1>
        <form action="{{ route('admin.posts.store') }}" method="post">
            @csrf
            <div class="row gy-5">
                <div class="col-12">
                    <input type="text" class="form-control"
                    @error('title') is-valid @enderror id="title"
                    name="title">

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                </div>
                <div class="col-12 my-5">
                    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Inserisci testo.."></textarea>
                </div>
                <div class="col-12 mb-4">
                <select class="custom-select" name="category_id">

                    @error('category_id') is-valid @enderror>
                        <option value=""> Nessuna categoria</option>
                        @foreach ($categories as $category) @endforeach
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (old('category_id', $post->category_id) == $category->id) selected @endif>
                            {{ $category->label }}</option>
                    @endforeach
                    
                </select>

                @error('category_id')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror

                </div>
                <div class="col-12">
                    <input type="text" class="form-control" placeholder="Url Immagine" name="image" id="image">
                </div>
            </div>
            <div class="controls d-flex justify-content-end mt-2">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary mr-2">Indietro</a>
                <button type="submit" class="btn btn-success">Conferma</button>
            </div>
        </form>
    </div>
@endsection