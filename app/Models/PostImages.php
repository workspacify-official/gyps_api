<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImages extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table      = 'post_images';

    protected $hidden = ['id', 'post_id', 'created_at', 'updated_at'];
}
