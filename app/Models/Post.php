<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }
    public function comment(){
        return $this->hasMany(Comment::class)->latest();
    }
    public function like(){
        return $this->hasMany(Like::class);
    }

    public function isLiked(){
        return $this->like()->where('user_id', Auth::user()->id)->exists();
    }

    public function hasCategory(){
        return $this->categoryPost()->exists();
    }
}
