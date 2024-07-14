<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }
    public function profile(){
        return view('user.profile.view');
    }

    public function updateProfile (Request $request){
        $request -> validate([
            'name'=>'required',
            'phone'=>'required|regex:/(01)[0-9]{9}/', 
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        $user= Auth::User();
        if ($request->hasFile('image')) {
            if (File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            $image= $request->image;
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('/uploads/profiles');
            $image->move($destination, $image_name);
            $user->image = '/uploads/profiles/' . $image_name;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();
        toastr()->success('User Profile has been Updated successfully!');
        return redirect()->back();

    }

    public function updatePassword (){
        return view('user.password.view');


    }

    public function storePassword (Request $request){

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required','confirmed','min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);
        toastr()->success('User Password has been Updated successfully!');
        return redirect()->back();


    }
}
