<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveRoom extends Model
{
    use HasFactory;
    protected $table = 'live_rooms';
    protected $primarykey = 'id';
}
