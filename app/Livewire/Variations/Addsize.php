<?php

namespace App\Livewire\Variations;

use Livewire\Component;
use App\Models\Size;
use Illuminate\Support\Carbon;

class Addsize extends Component
{
    // public $sudip = "";
    public $size;
    public function size_insert()
    {
        Size::insert([
            'size'=>$this->size,
            'user_id'=>auth()->id(),
            'created_at'=>Carbon::now(),
        ]);
        $this->reset();
        // return back();
        session()->flash('success', 'Size Successfully Added.');
    }
    public function delete_size($id)
    {
        Size::find($id)->delete();
    }
    public function render()
    {
        $sizes = Size::where('user_id', auth()->id())->latest()->get();
        return view('livewire.variations.addsize', compact('sizes'));
    }
}
