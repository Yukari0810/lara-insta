<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    const ADMIN_ROLE_ID = 1;
    const ADMIN_USER_ID = 2;

    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function post(){
        return $this->hasMany(Post::class)->latest();
    }

    public function like(){
        return $this->hasOne(Like::class);
    }

    // gets your followers
    public function followers(){
        return $this->hasMany(Follow::class,'following_id');
    }

    public function following(){
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function isFollowed(){
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
    }

    // public function isAdmin(){
    //     if(Auth::user()->role_id == 1){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

}
