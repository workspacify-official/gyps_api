<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileImages extends Model
{
    use HasFactory;
    protected $table        = 'profile_images';
    protected $primaryKey   = 'img_id';

    protected $hidden = ['created_at', 'updated_at', 'user_id'];
}
