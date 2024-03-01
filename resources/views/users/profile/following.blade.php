@extends('layouts.app')

@section('title', 'Show Following')

@section('content')

@include('users.profile.content.head')

<div class="row justify-content-center" style="margin-top: 100px">
    @if ($detail->following->isNotEmpty())
    <div class="col-4 mx-auto">
        <h3 class="text-muted mb-2 text-center">Following</h3>

        @foreach ($detail->following as $following)
        <div class="row align-items-center mb-3">
            <div class="col-auto col-md-2">
                <a href="/profile/show/{{$following->following->id}}">
                    @if ($following->following->avatar)
                    <img src="{{$following->following->avatar}}" alt="" class="rounded-circle avatar-sm">
                    @else
                    <i class="fa-solid fa-circle-user icon-sm text-secondary avatar-sm"></i>
                    @endif
                </a>
            </div>
            <div class="col text-truncate fw-bold">
                <a href="/profile/show/{{$following->following->id}}" class="text-decoration-none text-dark">
                    {{$following->following->name}}
                </a>
                {{-- <p class="mb-0">{{$following->email}}</p>
                <span class="text-muted xsmall">{{$following->following->following->count()}} following</span> --}}
            </div>
            <div class="col text-center p-2">
                {{-- <div class="col-auto p-2"> --}}
                    @if ($following->following->id == Auth::user()->id)
                    {{-- nothing --}}
                    @elseif ($following->following->deleted_at)
                    <p class="text-danger my-auto">deactivated</p>
                    @elseif ($following->following->isFollowed())
                    <form action="{{route('follow.delete')}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="following" value="{{$following->following->id}}">
                        <button type="submit" class="btn btn-none text-secondary btn-sm">
                            Following
                        </button>
                    </form>
                    @else
                    <form action="{{route('follow.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="following" value="{{$following->following->id}}">
                        <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                    </form>
                    @endif
                {{-- </div> --}}
            </div>
        </div>
        @endforeach
    </div>
    @else
    <h2 class="text-muted text-center">No following yet</h2>
    @endif
</div>
@endsection

