<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pull_table extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'pull_tables';
    protected $hidden = ['user_id', 'created_at', 'updated_at'];

    public function images()
    {
        return $this->hasMany(Pull_file::class, 'pull_id', 'id');
    }

}
