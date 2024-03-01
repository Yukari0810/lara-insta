@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<form action="/post/update/{{$detail->id}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <label for="" class="form-label d-block fw-bold">Category<span class="text-muted fw-normal"> (up to 3)</span></label>
    <div class="">
        @foreach ($categories as $category)
        <div class="form-check form-check-inline">
            <input type="checkbox" id="{{$category->name}}" class="form-check-input" name="category[]" value="{{$category->id}}"
            @foreach ($detail->categoryPost as $category_post)
            @if ($category_post->category_id == $category->id)
            checked
            @endif
            @endforeach
            >
            <label for="{{$category->name}}" class="form-check-label">{{$category->name}}</label>
        </div>
        @endforeach
    </div>
    <div class="mt-3">
        <label for="" class="form-label d-block fw-bold">Description</label>
        <textarea name="description" id="" rows="3" placeholder="What's on your mind?" class="form-control">{{$detail->description}}</textarea>
    </div>
    <div class="mt-3">
        <label for="" class="form-label d-block fw-bold">Image</label>
        <div class="row mt-2">
            <div class="col-6">
                <img src="{{$detail->image}}" alt="" class="img-thumbnail">
                <input type="file" class="form-control mt-2" name="image" accept="image/jpg, image/jpeg, image/png, image/gif">
                <span class="form-text">Accepted formats: jpg, jpeg, png, gif<br>Max size: 1MB or 1024KB</span>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary px-5">Post</button>
    </div>
</form>
@endsection

