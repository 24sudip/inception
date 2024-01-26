<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    use HasFactory;

    // function relation_to_gallery()
    // {
    //     return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    // }
    protected $guarded = [];
}
