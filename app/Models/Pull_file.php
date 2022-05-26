<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pull_file extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'pull_files';
    protected $hidden = ['created_at', 'updated_at', 'pull_id'];
}
