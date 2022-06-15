<?php
namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MyPost extends Model
{
   
   
    public function images()
    {
        return $this->hasMany(PostImages::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id')->whereNull('parent_id');
    }


    public function followingcheck()
    {
        return $this->hasMany(Follower::class, 'following_id', 'user_id');
    }


    public function comments_count()
    {
       return $this->hasMany(Comments::class, 'post_id', 'id'); 
    }






}
