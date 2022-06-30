<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveRoomChat extends Model
{
    use HasFactory;
    protected $table        = 'live_room_chats';
    protected $primaryKey   = 'id';
    protected $hidden = ['created_at', 'updated_at'];
}
