@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mx-auto w-50">
            @if ($post->image)
                <img  src="{{ asset(`storage/$post->image`) }}" alt="placeholder" class="img-fluid"
                    id="preview">
            @else
                <img src=" https://icons.iconarchive.com/icons/ccard3dev/dynamic-yosemite/1024/Preview-icon.png"
                    alt="placeholder" class="img-fluid" id="preview">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->description }}</p>
                <div>
                    @if ($post->tags)
                        @foreach ($post->tags as $tag)
                            <div class="badge" style="background-color: {{ $tag->color }}">{{ $tag->label }}</div>
                        @endforeach
                    @endif
                </div>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
@endsection