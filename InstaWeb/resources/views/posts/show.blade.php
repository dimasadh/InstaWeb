@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-100 mb-100">
    <div class="row">
        <div class="col-6">
            <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="col-6">
            <div>
                <div class="d-flex align-items-center">
                    <div class="pr-3">
                        <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100" style="max-width:50px" alt="">
                    </div>
                    <div>
                        <h3>
                            <a href="/profile/{{ $post->user->id }}">
                                <span class="text-dark"> {{ $post->user->username }} </span>
                            </a>
                        </h3>
                    </div>
                </div>
            </div>

            <hr>

            <p>{{ $post->caption }}</p>
        </div>

        <!-- comment section -->

        <div class="col-md-12 pt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Comments</h4>
                    <h6 class="card-subtitle">Latest Comments section by users</h6>
                </div>
                @foreach($post->comments as $comment)
                <div class="comment-widgets m-b-20">
                    <div class="d-flex flex-row comment-row">
                        <div class="p-2">
                            <span class="round">
                                <img src="{{ $comment->user->profile->profileImage() }}" alt="user" width="50">
                            </span>
                        </div>
                        <div class="comment-text w-100">
                            <h5>{{$comment->user->username}}</h5>
                            <div class="comment-footer">
                                <span class="date">{{$comment->created_at}}</span> 
                                @can('delete', $comment)
                                    <span>
                                        <a href="/c/{{ $comment->id }}/d" data-abc="true">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    <span>
                                @endcan
                            </div>
                            <p class="m-b-5 m-t-10">{{$comment->comment}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- end of comment section -->

        <!-- add comment section -->
        <form action="/p/{{ $post->id }}/c" enctype="multipart/form-data" method="post" id="comment-form" class="col-md-12 pt-5 form-block">
        @csrf
            <div class="col-xs-12">
                <div class="form-group">
                    <textarea name="comment" class="form-input" required="" form="comment-form" placeholder="Your comment"></textarea>
                </div>
            </div>
            @error('comment')
            <span class="invalid-feedback" style="display:block" role="alert">
                <strong>{{ $errors->first('comment') }}</strong>
            </span>
            @enderror
            <input type="submit" value="Submit" class="btn btn-primary pull-right">
	    </form>

        @if (\Session::has('message'))
            <div class="alert alert-success" >
                <ul>
                    <li>{!! \Session::get('message') !!}</li>
                </ul>
            </div>
        @endif

        <!-- end of add comment section -->

    </div>
</div>
@endsection