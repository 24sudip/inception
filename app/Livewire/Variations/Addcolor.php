<?php

namespace App\Livewire\Variations;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Color;
use Illuminate\Support\Carbon;

class Addcolor extends Component
{
    #[Validate('required')]
    public $color;
    #[Validate('required')]
    public $color_code;

    public function color_insert()
    {
        $this->validate();
        Color::create([
            'color'=>$this->color,
            'color_code'=>$this->color_code,
            'created_at'=>Carbon::now(),
        ]);
        // $this->reset();
        $this->inputReset();
        session()->flash('colrAddMsg', 'Color Successfully Added.');
    }
    public function color_update($id)
    {
        Color::find($id)->update([
            'color'=>$this->color,
            'color_code'=>$this->color_code,
            'updated_at'=>Carbon::now(),
        ]);
        session()->flash('colrUpdtMsg', 'Color Successfully Updated.');
    }

    public function inputReset()
    {
        $this->color = "";
        $this->color_code = "";
    }

    public function edit_color($id)
    {
        $editColors = Color::where('id', $id)->first();
        $this->color = $editColors->color;
        $this->color_code = $editColors->color_code;
    }

    public function render()
    {
        $colors = Color::all();
        return view('livewire.variations.addcolor', compact('colors'));
    }
}
