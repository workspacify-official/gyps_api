<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveRoom extends Model
{
    use HasFactory;
    protected $table = 'live_rooms';
    protected $primarykey = 'id';


    public function followingcheck()
    {
        return $this->hasMany(Follower::class, 'following_id', 'user_id');
    }


}
