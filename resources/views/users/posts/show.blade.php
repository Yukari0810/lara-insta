@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
<div class="row border shadow">
    <div class="col-8 p-0">
        <img src="{{$post->image}}" alt="" class="w-100">
    </div>
    <div class="col-4 p-0 bg-white">
        <div class="card border-0">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-auto">
                        @if ($post->user->avatar)
                        <img src="{{$post->user->avatar}}" alt="" class="rounded-circle avatar-sm">
                        @else
                        <i class="fa-solid fa-circle-user icon-sm text-secondary"></i>
                        @endif
                    </div>
                    <div class="col ps-0">
                        <a href="{{route('profile.show', $post->user_id)}}" class="text-decoration-none text-dark">{{$post->user->name}}</a>
                    </div>
                    <div class="col-auto">
                        <div class="dropdown">
                            <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            @if ($post->user->id == Auth::user()->id)
                            <div class="dropdown-menu">
                                <a href="/post/edit/{{$post->id}}" class="dropdown-item">
                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                </a>
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-{{$post->id}}">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </button>
                            </div>

                            <div class="modal fade" id="delete-{{$post->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content border-danger">
                                        <div class="modal-header border-danger">
                                            <h3 class="h5 modal-title text-danger">
                                                <i class="fa-solid fa-circle-exclamation"></i>
                                                Delete Post
                                            </h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Are you sure you want to delete this post?
                                            </p>
                                            <div class="mt-3">
                                                <img src="{{$post->image}}" alt="" class="img-thumbnail">
                                                <p class="mt-1 text-muted">{{$post->description}}</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <form action="/post/delete/{{$post->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                {{-- <input type="hidden" name="_token" value="">
                                                <input type="hidden" name="_method" value="DELETE"> --}}
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="dropdown-menu">
                                @if ($post->user->isFollowed())
                                <form action="{{route('follow.delete')}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="following" value="{{$post->user_id}}">
                                    <button type="submit" class="dropdown-item text-danger">
                                        Unfollow
                                    </button>
                                </form>
                                @else
                                <form action="{{route('follow.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="following" value="{{$post->user_id}}">
                                    <button type="submit" class="dropdown-item text-primary">
                                        Follow
                                    </button>
                                </form>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white px-3 py-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        {{-- ハートボタン --}}
                        {{-- ここもボタンを押したかどうかで、表示と機能を変えないといけない --}}
                        @if ($post->isLiked())
                        <form action="/like/delete" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <button type="submit" class="btn btn-sm shadow-none p-0">
                                <i class="fa-solid fa-heart fa-2x text-danger"></i>
                            </button>
                        </form>
                        @else
                        <form action="/like/store" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <button type="submit" class="btn btn-sm shadow-none p-0">
                                <i class="fa-regular fa-heart fa-2x"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                    <div class="col-auto px-0">
                        {{-- likeの数表示と誰が押したかわかるボタン --}}
                        <button type="button" class="btn btn-sm shadow-none p-0 fw-bold" data-bs-toggle="modal" data-bs-target="#like-{{$post->id}}">
                            <span>{{$post->like->count()}}</span>
                        </button>

                        {{-- モーダルウィンドウ --}}
                        <div class="modal fade" id="like-{{$post->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content border-success">
                                    <div class="modal-header border-success justify-content-center">
                                        <h3 class="h5 modal-title text-dark" id="all-likes-post-19">
                                            <i class="fa-solid fa-heart text-danger"></i>
                                            Likes
                                        </h3>
                                    </div>
                                    <hr class="m-0">

                                    <div class="modal-body justify-content-center">
                                        {{-- 誰かがlikeを押していたら誰がlikeを押したのかをアイコンとユーザーネームで表示する --}}
                                        @foreach ($post->like as $liker)
                                        <div class="row mb-2">
                                            <div class="col text-end">
                                                @if ($liker->user->avatar)
                                                <img src="{{$liker->user->avatar}}" alt="" class="rounded-circle avatar-sm">
                                                @else
                                                <i class="fa-solid fa-circle-user icon-sm text-secondary avatar -sm"></i>
                                                @endif
                                            </div>
                                            <div class="col d-flex align-items-center">
                                                <p class="my-auto">{{$liker->user->name}}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- カテゴリー表示 --}}
                    <div class="col text-end">
                        @foreach ($post->categoryPost as $category_post)
                        <span class="badge bg-secondary bg-opacity-50 text-decoration-none">
                            {{$category_post->category->name}}
                        </span>
                        @endforeach
                    </div>
                </div>
                <div class="mt-1">
                    <a href="{{route('profile.show', $post->user_id)}}" class="text-decoration-none text-dark fw-bold">
                        {{$post->user->name}}
                    </a>
                    &nbsp;
                    <p class="d-inline fw-light">
                        <span>
                            {{$post->description}}
                        </span>
                    </p>
                    <p class="text-muted text-uppercase xsmall">
                        {{$post->created_at->diffForHumans()}}
                    </p>
                </div>

                {{-- コメント --}}


                @foreach ($post->comment as $comment)

                @if ($loop->index == 0)
                <hr class="text-muted">
                @endif

                <div class="mb-1">
                    <a href="{{route('profile.show', $comment->user_id)}}" class="text-decoration-none text-dark fw-bold">
                        {{$comment->user->name}}
                    </a>
                    &nbsp;
                    <p class="d-inline fw-light">
                        <span>
                            {{$comment->description}}
                        </span>
                    </p>
                    @if ($comment->user_id == Auth::user()->id)
                    <form action="{{route('comment.delete', $comment)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <span class="text-muted text-uppercase xsmall">
                            {{$comment->created_at->diffForHumans()}}
                        </span>
                        &nbsp;
                        <button type="submit" class="btn btn-none btn-smlborder-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                    </form>
                    @else
                    <p class="text-muted text-uppercase xsmall">
                        {{$comment->created_at->diffForHumans()}}
                    </p>
                    @endif
                </div>

                @endforeach

                <div class="mt-3 mb-1">
                    <form action="/comment/store/{{$post->id}}" method="POST">
                        @csrf
                        <div class="input-group">
                            <textarea name="comment" class="form-control form-control-sm" rows="1" placeholder="Add a comment"></textarea>
                            <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

