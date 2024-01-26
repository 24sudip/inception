<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\Inventory;
use Illuminate\Support\Carbon;

class InventoryController extends Controller
{
    public function inventory($id)
    {
        $product = Product::find($id);
        $sizes = Size::all();
        $colors = Color::all();
        $inventory = Inventory::where('product_id', $id)->get();
        return view('layouts.dashboard.product.inventory', [
            'sizes'=>$sizes,
            'product'=>$product,
            'inventory'=>$inventory,
            'colors'=>$colors,
        ]);
    }
    public function inventoryStore(Request $request, $id)
    {
        Inventory::insert([
            'product_id'=>$id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
}
