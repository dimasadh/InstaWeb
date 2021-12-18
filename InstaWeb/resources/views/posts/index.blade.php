@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts as $post)
    <div class="row pt-2 pb-4">
        <div class="col-5">
            <a href="/p/{{ $post->id }}">
                <img src="/storage/{{ $post->image}}" class="w-100">
            </a>
        </div>
        <div class="col-6">
            <div>
                <div class="d-flex align-items-center">
                    <div>
                        <h3>
                            <a href="/profile/{{ $post->user->id }}">
                                <span class="text-dark"> {{ $post->user->username }} </span>
                            </a>
                        </h3>
                    </div>
                </div>
            </div>

            <p>{{ $post->caption }}</p>
        </div>
    </div>
    @endforeach

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links('pagination::bootstrap-4') }}
            </div>
        </div>
</div>
@endsection