@extends('layouts.app')

@section('title', 'Suggestions')

@section('content')
<div class="row">
    <div class="col-6 mx-auto">
        <p class="fw-bold text-muted">Suggested</p>

        @foreach ($suggestion as $suggested_user)
        <div class="row align-items-center mb-4">
            <div class="col-4 col-md-2 text-center">
                <a href="/profile/show/{{$suggested_user->id}}">
                    @if ($suggested_user->avatar)
                    <img src="{{$suggested_user->avatar}}" alt="" class="rounded-circle avatar-sm">
                    @else
                    <i class="fa-solid fa-circle-user icon-sm text-secondary avatar-sm"></i>
                    @endif
                </a>
            </div>
            <div class="col-auto text-truncate">
                <a href="/profile/show/{{$suggested_user->id}}" class="text-decoration-none text-dark">
                    {{$suggested_user->name}}
                </a>
                <p class="mb-0">{{$suggested_user->email}}</p>
                <span class="text-muted xsmall">{{$suggested_user->followers()->count()}} followers</span>
            </div>
            <div class="col text-end">
                <form action="{{route('follow.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="following" value="{{$suggested_user->id}}">
                    <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                </form>
            </div>
        </div>

        @endforeach
    </div>
</div>
@endsection

