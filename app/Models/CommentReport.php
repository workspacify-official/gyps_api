<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReport extends Model
{
    use HasFactory;
    protected $table = 'comment_reports';
    protected $primaryKey = 'id';
    protected $hidden = ['created_at', 'updated_at'];
}
