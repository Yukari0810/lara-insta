<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    //
    private $category;
    private $post;
    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;
    }

    public function index(){

        $all_categories = $this->category->orderBy('id', 'desc')->get();
        $all_posts = $this->post->get();

        $uncategorized = 0;
        foreach($all_posts as $post){
            if($post->categoryPost->count() == 0){
                $uncategorized ++;
            }
        }
        return view('admin.categories.index')->with('all_categories', $all_categories)->with('uncategorized', $uncategorized);

    }
    public function delete($id){
        $this->category->destroy($id);
        return redirect()->back();
    }

    public function store(Request $request){
        $this->category->name = $request->name;
        $this->category->save();
        return redirect()->back();
    }

    public function update(Request $request, $category_id){
        $update = $this->category->findOrFail($category_id);
        $update->name = $request->name;
        $update->save();
        return redirect()->back();
    }

}
