<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }
    //
    public function index(){
        $all_users = $this->user->withTrashed()->latest()->paginate(8);
        return view('admin.users.index')->with('all_users', $all_users);
    }

    // soft delete function
    // delete function did not work. This should be done with destroy for now.
    public function deactivate($user_id){

        $this->user->destroy($user_id);

        return redirect()->back();
    }

    //activate func
    public function activate($user_id){

        $this->user->onlyTrashed()->where('id', $user_id)->restore();

        return redirect()->back();
    }
}
