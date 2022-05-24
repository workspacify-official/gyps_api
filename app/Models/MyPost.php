<?php
namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MyPost extends Model
{
   
   
    public function images()
    {
        return $this->hasMany('App\Models\PostImages', 'post_id');
    }


}
