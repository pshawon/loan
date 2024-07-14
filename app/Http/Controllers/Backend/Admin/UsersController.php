<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;


class UsersController extends Controller
{
    public function allUsers (){
        $users= User::all();
        return view('admin.users.all_users',compact('users'));

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
        return view('admin.users.detail',compact('user'));

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
