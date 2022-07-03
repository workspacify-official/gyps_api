<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class live_rooms_participant extends Model
{
    use HasFactory;
    protected $table = 'live_rooms_participants';
    protected $primaryKey = 'id';

    public function followingcheck()
    {
        return $this->hasMany(Follower::class, 'following_id', 'user_id');
    }

}
