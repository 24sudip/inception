<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Size;
use App\Models\Color;

class Inventory extends Model
{
    use HasFactory;

    function relation_to_size() {
        return $this->belongsTo(Size::class, 'size_id');
    }
    function relation_to_color() {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
