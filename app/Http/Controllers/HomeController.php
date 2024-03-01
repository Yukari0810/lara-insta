<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;
    private $user;
    // private $categoryPost;
    // private $like;
    // private $follow;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->middleware('auth');
        $this->post = $post;
        $this->user = $user;
        // $this->categoryPost = $categoryPost;
        // $this->like = $like;
        // $this->follow = $follow;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];
        $suggestion = [];
        foreach($all_posts as $post){
           if($post->user->isFollowed()|| $post->user_id == Auth::user()->id){
            $home_posts[] = $post;
           }
        }

        $all_users = $this->user->latest()->get();
        foreach($all_users as $user){
            if(!$user->isFollowed() && $user->id != Auth::user()->id){
                $suggestion[] = $user;
            }
        }

        array_splice($suggestion, 10);

        return view('users.home')->with('home_posts', $home_posts)->with('suggestion', $suggestion);
    }

    public function all_suggest(){
        $all_users = $this->user->latest()->get();
        $suggestion = [];
        foreach($all_users as $user){
            if(!$user->isFollowed() && $user->id != Auth::user()->id){
                $suggestion[] = $user;
            }
        }
        return view('users.suggestions.index')->with('suggestion', $suggestion);
    }

    public function search(Request $request){
        $suggestions = $this->user->where('name', 'LIKE', '%'.$request->keyword.'%')->get();
        return view('search.result')->with('suggestions', $suggestions);
    }
}
