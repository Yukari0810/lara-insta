<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    //
    private $post;
    public function __construct(Post $post){
        $this->post = $post;
    }

    public function index(){
        $all_posts = $this->post->withTrashed()->latest()->paginate(8);
        return view('admin.posts.index')->with('all_posts', $all_posts);
    }

    // hide function
    public function hide($post_id){
        $this->post->destroy($post_id);
        return redirect()->back();
    }
    //
    public function show($post_id){
        $this->post->onlyTrashed()->where('id', $post_id)->restore();
        return redirect()->back();
    }
}
