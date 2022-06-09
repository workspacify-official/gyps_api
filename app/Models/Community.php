<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;
    protected $table        = 'communities';
    protected $primaryKey   = 'id';
    protected $hidden       = ['created_at', 'updated_at'];
}
