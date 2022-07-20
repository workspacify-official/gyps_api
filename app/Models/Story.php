<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $table        = 'stories';
    protected $primaryKey   = 'id';

    public function storys()
    {
        return $this->hasMany(Story::class, 'user_id', 'user_id');
    }

}
