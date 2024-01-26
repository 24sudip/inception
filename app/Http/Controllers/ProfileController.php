<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('layouts.dashboard.profile.profile');
    }
    public function profile_photo_upload(Request $request)
    {
        // return $request->file('profile_photo');|mimes:jpeg,png,jpg,gif,svg|max:2048
        $request->validate([
            'profile_photo' => 'required|image',
        ]);
        // Image Intervention
        $new_name = Auth::user()->id . "." . $request->file('profile_photo')->getClientOriginalExtension();

        $img =Image::make($request->file('profile_photo'))->resize(200, 200);
        $img->save(base_path('public/uploads/profile_photos/' . $new_name), 80);
        User::find(auth()->id())->update(
            [
                'profile_photo'=> $new_name,
            ]);
            return back()->with('photoSuccess','Your Profile Picture Uploaded Successfully');
        // Image Intervention
    }
    public function password_change(Request $request)
    {
        // return $request;
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        if (Hash::check($request->old_password, auth()->user()->password)) {
            User::find(auth()->user()->id)->update([
                'password' => bcrypt($request->password),
            ]);
            return back()->with('passChngSuccess','Password Changed Successfully');
        } else {
            return back()->withErrors('Old Password Is Wrong');
        }
    }
}
