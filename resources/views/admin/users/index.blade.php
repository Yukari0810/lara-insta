@extends('layouts.app')

@section('title', 'Admin Users')

@section('admin_content')
<div class="col-3">
    @include('admin.users.content.menu')
</div>
<div class="col-9">
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="table-success">
          <tr>
            <th></th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>CREATED AT</th>
            <th>STATUS</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($all_users as $user)
            <tr class="">
                <td class="text-center">
                    @if ($user->avatar)
                    <img src="{{$user->avatar}}" class="rounded-circle avatar-md">
                    @else
                    <i class="fa-solid fa-circle-user icon-sm text-secondary icon-md"></i>
                    @endif
                </td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at->format('d/m/Y')}}</td>
                <td>
                    @if ($user->trashed())
                    <i class="fa-solid fa-circle text-secondary"></i> &nbsp;
                    Not Active
                    @else
                    <i class="fa-solid fa-circle text-success"></i> &nbsp;
                    Active
                    @endif
                </td>
                <td>
                    {{-- if the user is deactivated --}}
                    @if ($user->deleted_at)
                    <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#activate-user-{{$user->id}}">
                                <i class="fa-solid fa-user"></i> Activate pen
                            </button>
                        </div>
                    </div>
                    <div class="modal fade" id="activate-user-{{$user->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content border-primary">
                                <div class="modal-header border-primary">
                                    <h3 class="h5 modal-title text-primary">
                                        <i class="fa-solid fa-user"></i> Activate User
                                    </h3>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to activate <span class="fw-bold">pen</span>?
                                </div>
                                <div class="modal-footer border-0">
                                    <form action="{{route ('admin.users.activate', $user->id)}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Activate
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    {{-- if the user is active --}}
                    <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{$user->id}}">
                                <i class="fa-solid fa-user-slash"></i> Deactivate pen
                            </button>
                        </div>
                    </div>
                    <div class="modal fade" id="deactivate-user-{{$user->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content border-danger">
                                <div class="modal-header border-danger">
                                    <h3 class="h5 modal-title text-danger">
                                        <i class="fa-solid fa-user-slash"></i> Deactivate User
                                    </h3>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to deactivate <span class="fw-bold">pen</span>?
                                </div>
                                <div class="modal-footer border-0">
                                    <form action="{{route ('admin.users.deactivate', $user->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Deactivate
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
        {{ $all_users->links() }}
    </div>
</div>
@endsection

