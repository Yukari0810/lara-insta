@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class=""></div>
<div class="border shadow justify-content-center p-5">
    <h2 class="mb-3 text-muted">Edit Profile</h2>
    <form action="{{route('profile.update', $detail->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row mb-3">
            <div class="col-4 text-center">
                @if ($detail->avatar)
                <img src="{{$detail->avatar}}" alt="" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
                @else
                <i class="fa-solid fa-circle-user icon-sm text-secondary avatar fa-9x"></i>
                @endif

            </div>
            <div class="col-auto align-self-center">
                <input type="file" name="avatar" class="form-control form-control-sm mt-1">
                <label for="" class="form-text">Accepted file types: jpg, jpeg, png, gif, Max file size 1048kb.</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label fw-bold">Name</label>
            <input type="text" value="{{$detail->name}}" class="form-control" name="name">
        </div>
        <div class="mb-3">
            <label for="" class="form-label fw-bold">Email</label>
            <input type="text" value="{{$detail->email}}" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="" class="form-label fw-bold">Introduction</label>
            <textarea class="form-control" name="introduction" placeholder="Describe yourself!" rows="5">{{$detail->introduction}}</textarea>
        </div>
        <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
</div>
@endsection

