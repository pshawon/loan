<?php

namespace App\Http\Controllers\Backend\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('super_admin.dashboard');
    }
    public function profile(){
        return view('super_admin.profile.view');
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
        toastr()->success('Profile has been Updated successfully!');
        return redirect()->back();

    }

    public function updatePassword (){
        return view('super_admin.password.view');


    }
    public function storePassword (Request $request){

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required','confirmed','min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);
        toastr()->success('Password has been Updated successfully!');
        return redirect()->back();


    }


    public function allUsers (){
        $users= User::all();
        $users = $users->filter(function($users) {
            return $users->id !== Auth::id();
        });
        return view('super_admin.users.all_users',compact('users'));

    }

    public function deleteUser ($user){
        $user= User::findOrFail($user);
        if (File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }
        $user->delete();
        toastr ()->success('User Deleted Successfully','Congrats');
        return redirect()->back();
    }

    public function userDetail($id){

        $user= User::findOrFail($id);
        return view('super_admin.users.detail',compact('user'));

    }

    public function toggleRole(Request $request,$id){

        $user= User::findOrFail($id);
        $user->role= ($request->has('role')) ? 'admin' : 'user';
        $user->save();
        toastr ()->success('User Role Updated Successfully','Congrats');
        return redirect()->back();

    }

    public function toggleStatus(Request $request,$id){

        $user= User::findOrFail($id);
        $user->status= ($request->has('status')) ? 'active' : 'inactive';
        $user->save();
        toastr ()->success('User Status Updated Successfully','Congrats');
        return redirect()->back();

    }



}
