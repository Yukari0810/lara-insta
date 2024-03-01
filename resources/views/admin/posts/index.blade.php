@extends('layouts.app')

@section('title', 'Admin Posts')

@section('admin_content')
<div class="col-3">
    @include('admin.users.content.menu')
</div>
<div class="col-9">
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="table-success">
          <tr>
            <th></th>
            <th></th>
            <th>CATEGORY</th>
            <th>OWNER</th>
            <th>CREATED AT</th>
            <th>STATUS</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $post)
            <tr class="">
                <td>{{$post->id}}</td>
                <td class="col-3">
                    <img src="{{$post->image}}" alt="" class="img-thumbnail">
                </td>
                <td>
                    @foreach ($post->categoryPost as $category_post)
                        <span class="badge bg-secondary bg-opacity-50 text-decoration-none">
                            {{$category_post->category->name}}
                        </span>
                    @endforeach
                </td>
                <td>{{$post->user->name}}</td>
                <td>{{$post->created_at->format('d/m/Y')}}</td>
                <td>
                    @if ($post->trashed())
                    <i class="fa-solid fa-circle text-secondary"></i> &nbsp;
                    Not Visible
                    @else
                    <i class="fa-solid fa-circle text-primary"></i> &nbsp;
                    Visible
                    @endif
                </td>
                <td>
                    @if ($post->deleted_at)
                    <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#show-post-{{$post->id}}">
                                <i class="fa-solid fa-user"></i> Show post
                            </button>
                        </div>
                    </div>
                    <div class="modal fade" id="show-post-{{$post->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content border-primary">
                                <div class="modal-header border-primary">
                                    <h3 class="h5 modal-title text-primary">
                                        <i class="fa-solid fa-user"></i> Show post
                                    </h3>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to show <span class="fw-bold">post</span>?</p>
                                    <div class="mt-3">
                                        <img src="{{$post->image}}" alt="" class="img-thumbnail">
                                        <p class="mt-1 text-muted">{{$post->description}}</p>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <form action="{{route ('admin.posts.show', $post->id)}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Show
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{$post->id}}">
                                <i class="fa-solid fa-eye-slash"></i> Hide Post {{$post->id}}
                            </button>
                        </div>
                    </div>
                    <div class="modal fade" id="hide-post-{{$post->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content border-danger">
                                <div class="modal-header border-danger">
                                    <h3 class="h5 modal-title text-danger">
                                        <i class="fa-solid fa-eye-slash"></i> Hide Post
                                    </h3>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Are you sure you want to hide this post?
                                    </p>
                                    <div class="mt-3">
                                        <img src="{{$post->image}}" alt="" class="img-thumbnail">
                                        <p class="mt-1 text-muted">{{$post->description}}</p>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <form action="{{ route('admin.posts.hide', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        {{-- <input type="hidden" name="_token" value="">
                                        <input type="hidden" name="_method" value="DELETE"> --}}
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hide
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>
    <div class="w-25 mx-auto mt-3">
        {{ $all_posts->links() }}
    </div>
</div>
@endsection

