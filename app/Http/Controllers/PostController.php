<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CategoryPost;
use App\Models\Like;

class PostController extends Controller
{
    private $category;
    private $post;
    private $categoryPost;
    private $like;
    public function __construct(Post $post, Category $category, CategoryPost $categoryPost, Like $like){
        $this->post = $post;
        $this->category = $category;
        $this->categoryPost = $categoryPost;
        $this->like = $like;
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
        $categories = $this->category->all();
        return view('users.posts.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|string|min:1|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048'
        ]);

        $this->post->description = $request->description;
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->user_id = Auth::user()->id;
        $this->post->save();


        foreach($request->category as $category_id){
            $category_post[] = ['category_id'=>$category_id];
        }

        // $category_post = [
        // [‘category_id’ => 1],
        // [‘category_id’ => 4]
        // ];

        $this->post->categoryPost()->createMany($category_post);

        // $category_post = [
        //     [‘category_id’ => 1, ‘post_id’ => 2],
        //     [‘category_id’ => 4, ‘post_id’ => 2]
        // ];
        return redirect()->route('index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        // $detail = $this->post->findOrFail($id);
        // return view('users.posts.show')->with('detail', $detail);
        return view('users.posts.show')->with('post', $post);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $categories = $this->category->all();
        $detail = $this->post->findOrFail($id);
        return view('users.posts.edit')->with('detail', $detail)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|string|min:1|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048'
        ]);
        
        $update = $this->post->findOrFail($id);
        $update->description = $request->description;
        if($request->image != ''){
            $update->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $update->save();

        // これじゃ二重になってしまうので、categoryPostをupdateできるようにしないといけない
        // $this->categoryPost->where('post_id', $id)->delete();
        $update->categoryPost()->delete();


        foreach($request->category as $category_id){
            $category_post[] = ['category_id'=>$category_id];
        }

        $update->categoryPost()->createMany($category_post);

        return redirect()->route('index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $this->post->destroy($id);
        return redirect()->back();
    }

}
