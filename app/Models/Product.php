<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    function relationWithProductToCategory() {
        return $this->belongsTo(Category::class, 'product_category', 'id');
    }
}
