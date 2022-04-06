@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mx-auto w-50">
            <img width="100px" src="{{ asset(`storage/$post->image`) }}" alt="{{ $post->title }}">>
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