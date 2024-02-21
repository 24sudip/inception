<!--  -->
<?php
// composer require intervention/image
require './vendor/autoload.php';

// namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SomeController extends Controller
{
    public function to_do_insert(Request $request)
    {
        if ($request->hasFile('image_field')) {
            $manager = new ImageManager(new Driver());
            $new_name = $request->name.".".$request->file('image_field')->getClientOriginalExtension();
            $img = $manager->read($request->file('image_field'));
            // $image->toPng()->save('images/foo.png');
            $img->toJpeg(80)->save(base_path('public/imageFolder/'.$new_name));
            User::insert([
                'name'=>$request->name,
                'image_field'=>$new_name,
            ]);
            return back();
        }
    }
}
?>
