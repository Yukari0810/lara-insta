@extends('layouts.app')

@section('title', 'Search Result')

@section('content')
<div class="row">
    @if ($suggestions->isEmpty())
    <div class="col-4 mx-auto">
        <h4 class="text-muted">No results found</h4>
    </div>
    @else
    <div class="col-6 mx-auto">
        <p class="fw-bold text-muted">Suggested</p>
        @foreach ($suggestions as $suggested_user)
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
            <div class="col text-truncate">
                <a href="/profile/show/{{$suggested_user->id}}" class="text-decoration-none text-dark">
                    {{$suggested_user->name}}
                </a>
                <p class="mb-0">{{$suggested_user->email}}</p>
                <span class="text-muted xsmall">{{$suggested_user->followers()->count()}} followers</span>
            </div>
            <div class="col">
                {{-- <div class="col-auto p-2"> --}}
                    @if ($suggested_user->id == Auth::user()->id)
                    {{-- nothing --}}
                    @elseif($suggested_user->isFollowed())
                    <form action="{{route('follow.delete')}}" method="POST" class="text-center">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="following" value="{{$suggested_user->id}}">
                        <button type="submit" class="btn btn-none text-secondary btn-sm">
                            Following
                        </button>
                    </form>
                    @else
                    <form action="{{route('follow.store')}}" method="POST" class="text-center">
                        @csrf
                        <input type="hidden" name="following" value="{{$suggested_user->id}}">
                        <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                    </form>
                    @endif
                {{-- </div> --}}
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection

