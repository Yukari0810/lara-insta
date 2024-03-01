<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $table = 'follows';
    public $timestamps = false;

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    public function followers(){
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }

    public function following(){
        return $this->belongsTo(User::class, 'following_id')->withTrashed();
    }
}
