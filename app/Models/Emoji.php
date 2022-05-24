<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emoji extends Model
{
    use HasFactory;
    protected $table = 'emoji';
    protected $primaryKey = 'id';

    protected $hidden =
    [
        'created_at',
        'updated_at'
    ];

}



