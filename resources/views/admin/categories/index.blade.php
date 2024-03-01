@extends('layouts.app')

@section('title', 'Admin Category')

@section('admin_content')
<div class="col-3">
    @include('admin.users.content.menu')
</div>
<div class="col-9">
    <form action="{{route('admin.categories.store')}}" class="row mb-3" method="POST">
        @csrf
        <div class="col-9">
            <input type="text" class="form-control" placeholder="Add a category..." name="name">
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
        </div>
    </form>
    <table class="table table-hover align-middle bg-white border text-secondary text-center">
        <thead class="table-warning">
          <tr>
            <th>#</th>
            <th>NAME</th>
            <th>COUNT</th>
            <th>LAST UPDATED</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($all_categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->categoryPost->count()}}</td>
                <td>
                    @if ($category->updated_at)
                    {{$category->updated_at->diffForHumans()}}
                    @else
                    <p class="text-danger">
                        Date Not Found
                    </p>
                    @endif
                </td>
                <td>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#update-category-{{$category->id}}" class="btn btn-outline-warning">
                        <i class="fa-solid fa-pen text-warning"></i>
                    </button>

                    <form action="{{route('admin.categories.delete', $category->id)}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
                <div class="modal fade" id="update-category-{{$category->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content border-warning">
                            <form action="{{route('admin.categories.update', $category->id)}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-header border-warning">
                                    <h3 class="h5 modal-title text-dark">
                                        <i class="fa-solid fa-pen-to-square"></i> Update Category
                                    </h3>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="form-control" name="name" value="{{$category->name}}">
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td>
                    <p class="mb-0">Uncategorized</p>
                    <label class="text-muted xsmall">Hidden posts are not included</label>
                </td>
                <td>
                    {{$uncategorized}}
                </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>

    </table>
</div>
@endsection

