@extends('layouts.app')

@section('title', 'Show Profile')

@section('content')
@include('users.profile.content.head')
<div class="" style="margin-top: 100px">
    @if ($detail->post->isNotEmpty())
    <div class="row">
        @foreach ($detail->post as $post)
        <div class="col-lg-4">
            <a href="{{route('post.show', $post)}}">
                <img src="{{$post->image}}" alt="" style="width: 100%; height: 300px; object-fit:cover;" class="mb-4">
            </a>
        </div>
        @endforeach
    </div>
    @else
    <h2 class="text-muted text-center">No posts yet</h2>
    @endif
</div>
@endsection

