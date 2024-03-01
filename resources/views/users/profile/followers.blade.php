@extends('layouts.app')

@section('title', 'Show Followers')

@section('content')
@include('users.profile.content.head')
<div class="row justify-content-center" style="margin-top: 100px">
    @if ($detail->followers->isNotEmpty())
    <div class="col-4 mx-auto">
        <h3 class="text-muted mb-2 text-center">Followers</h3>

        @foreach ($detail->followers as $follower)
        <div class="row align-items-center mb-3">
            <div class="col-auto col-md-2">
                <a href="/profile/show/{{$follower->followers->id}}">
                    @if ($follower->followers->avatar)
                    <img src="{{$follower->followers->avatar}}" alt="" class="rounded-circle avatar-sm">
                    @else
                    <i class="fa-solid fa-circle-user icon-sm text-secondary avatar-sm"></i>
                    @endif
                </a>
            </div>
            <div class="col text-truncate fw-bold">
                <a href="/profile/show/{{$follower->followers->id}}" class="text-decoration-none text-dark">
                    {{$follower->followers->name}}
                </a>
                {{-- <p class="mb-0">{{$follower->email}}</p>
                <span class="text-muted xsmall">{{$follower->followers->followers->count()}} followers</span> --}}
            </div>
            {{-- <div class="col-auto text-end"> --}}
            <div class="col text-center p-2">
                {{-- <div class="col-auto p-2"> --}}
                    @if ($follower->followers->id == Auth::user()->id)
                    {{-- nothing --}}
                    @elseif ($follower->followers->deleted_at)
                    <p class="text-danger my-auto">deactivated</p>
                    @elseif ($follower->followers->isFollowed())
                    <form action="{{route('follow.delete')}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="following" value="{{$follower->followers->id}}">
                        <button type="submit" class="btn btn-none text-secondary btn-sm">
                            Following
                        </button>
                    </form>
                    @else
                    <form action="{{route('follow.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="following" value="{{$follower->followers->id}}">
                        <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                    </form>
                    @endif
                {{-- </div> --}}
            </div>
        </div>
        @endforeach
    </div>
    @else
    <h2 class="text-muted text-center">No followers yet</h2>
    @endif
</div>
@endsection

