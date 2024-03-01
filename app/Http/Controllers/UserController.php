<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $profile;
    public function __construct(User $user){
        $this->profile = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $detail = $this->profile->findOrFail($id);
        return view('users.profile.show')->with('detail', $detail);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $detail = $this->profile->findOrFail($id);
        return view('users.profile.edit')->with('detail', $detail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string|min:1|max:50',
            'email' => 'required|email|min:1|max:50|unique:users,email,' . Auth::user()->id,
            'avatar' => 'mimes:jpeg,png,jpg,gif|max:1048',
            'introduction' => 'max:100'
        ]);

        $update = $this->profile->findOrFail($id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->introduction = $request->introduction;
        if($request->avatar){
            $update->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $update->save();
        return redirect()->route('profile.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function follower($id){
        $detail = $this->profile->findOrFail($id);
        return view('users.profile.followers')->with('detail', $detail);
    }

    public function following($id){
        $detail = $this->profile->findOrFail($id);
        return view('users.profile.following')->with('detail', $detail);
    }

}
