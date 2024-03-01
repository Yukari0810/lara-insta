<div class="row">
    <div class="col-4 text-center">
        @if ($detail->avatar)
        <img src="{{$detail->avatar}}" alt="" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
        @else
        <i class="fa-solid fa-circle-user icon-sm text-secondary avatar fa-10x"></i>
        @endif
    </div>
    <div class="col-8">
        <div class="row mb-3">
            <div class="col-auto">
                <h2 class="display-6 mb-0">{{$detail->name}}</h2>
            </div>
            {{-- ここも、自分のだったらedit profile ボタン、他人のだったらfollowボタンにする --}}
            @if ($detail->id == Auth::user()->id)
            <div class="col-auto p-2">
                <a href="/profile/edit/{{Auth::user()->id}}" class="btn btn-outline-secondary btn-sm">Edit Profile</a>
            </div>
            @elseif ($detail->isFollowed())
            <div class="col-auto p-2">
                {{-- <a href="" class="btn btn-outline-danger btn-sm">Unfollow</a> --}}
                <form action="{{route('follow.delete')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="following" value="{{$detail->id}}">
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        Unfollow
                    </button>
                </form>
            </div>
            @else
            <div class="col-auto p-2">
                <form action="{{route('follow.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="following" value="{{$detail->id}}">
                    <button type="submit" class="btn btn-primary btn-sm">
                        Follow
                    </button>
                </form>
            </div>
            @endif
        </div>
        <div class="row mb-3">
            <div class="col-auto">
                <a href="{{ route('profile.show', $detail->id)}}" class="text-decoration-none text-dark">
                    {{$detail->post->count()}} post
                </a>
            </div>
            <div class="col-auto">
                <a href="{{route('profile.follower', $detail->id)}}" class="text-decoration-none text-dark">
                    {{$detail->followers()->count()}} followers
                </a>
            </div>
            <div class="col-auto">
                <a href="{{route('profile.following', $detail->id)}}" class="text-decoration-none text-dark">
                    {{$detail->following()->count()}} following
                </a>
            </div>
        </div>
        <div class="row">
            <p class="fw-bold">{{$detail->introduction}}</p>
        </div>
    </div>
</div>
