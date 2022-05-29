<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function post()
    {
        return $this->belongsTo(MyPost::class);
    }

    public function replies()
    {
        return $this->hasMany(Comments::class, 'parent_id');
    }

    

}
