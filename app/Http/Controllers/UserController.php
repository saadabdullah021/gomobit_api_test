<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function AddUser(Request $request)
    {
        $check_email = User::where('email', $request->email)->count();
        if ($check_email > 0) {
            $response = ['success' => 'false', 'message' => 'User already exists. Please enter valid email'];
            return $response;
        } else {
            $request->validate([
                'email' => 'required|email'
            ]);
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->zip_code = $request->input('zip_code');
            $user->password = bcrypt('password');
            $user->save();
            $response = ['success' => 'true', 'message' => 'User has been added successfully.'];
            return $response;
        }
    }

    public function GetUsers($id = null)
    {
        if ($id == null) {
            $all_users = User::all();
            $response = ['success' => 'Users Data ', 'data' => $all_users];
            return $response;
        } else {
            $user = User::find($id);
            $response = ['success' => 'User Data', 'data' => $user];
            return $response;
        }
    }
}
