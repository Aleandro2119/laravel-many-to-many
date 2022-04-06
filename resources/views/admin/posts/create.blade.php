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
        <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data novalidate">
            @csrf
            <div class="row gy-5">
                <div class="col-12">
                    <input type="text" class="form-control"
                    @error('title') is-invalid @enderror id="title"
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

                    @error('category_id') is--invalid @enderror>
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

                <div class="col-12">
                    <div class="form-check form-check-inline">
                        @foreach ($tags as $tag)
                            <input class="form-check-input ml-2" type="checkbox" id="tag-{{ $loop->iteration }}"
                                value="{{ $tag->id }}" name="tags[]" @if (in_array($tag->id, old('tags', []))) checked @endif>
                            <label class="form-check-label" for="tag-{{ $loop->iteration }}">{{ $tag->label }}</label>
                        @endforeach
                    </div>
                </div>

                @if ($post->image)
                        <img src="{{ asset("storage/$post->image") }}" alt="placeholder" class="img-fluid" width="50"
                            id="preview">
                    @else
                        <img src=" https://icons.iconarchive.com/icons/ccard3dev/dynamic-yosemite/1024/Preview-icon.png"
                            alt="placeholder" class="img-fluid" width="50" id="preview">
                    @endif

                </div>
                <div class="col-12">
                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" placeholder="Url Immagine" name="image" id="image">
                </div>
            </div>
            <div class="controls d-flex justify-content-end mt-2">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary mr-2">Indietro</a>
                <button type="submit" class="btn btn-success">Conferma</button>
            </div>
        </form>
    </div>
@endsection