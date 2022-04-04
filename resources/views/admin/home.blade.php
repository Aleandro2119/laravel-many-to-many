@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="actions mt-3">
                        <a class="btn btn-secondary" href="{{ route('admin.posts.index') }}">Guarda i Tuoi Post</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection