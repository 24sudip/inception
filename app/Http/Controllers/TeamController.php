<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Carbon;


class TeamController extends Controller
{
    // public function service()
    // {
    //     return view('service');
    // }
    public function team()
    {
        $teams = Team::all();
        return view('teams', compact('teams'));
    }
    public function teamInsert(Request $request)
    {
        // return $request;
        // return $request->name;
        // return $request->number;
        $request->validate([
            'name'=>'required',
            'number'=>'required',
        ]);
        Team::insert([
            'name'=>$request->name,
            'number'=>$request->number,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('teamInsertMsg','Team Member Added Successfully');
    }
    public function teamDelete($id)
    {
        // return $id;
        Team::find($id)->delete();
        return back();
    }
}
