<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    public function showAllUser(){
        $users = User::all();
        return view('Admin.users', [
            'users' => $users
        ]);
    }

    public function add(Request $request){
        $user = new User();
        $user->username = $request->username;
        $user->displayname = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();
        
        return redirect()->route('users')->with('success', 'User added successfully');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
        
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
        
        $user->username = $request->username;
        $user->email = $request->email;
        
        // Only update password if provided
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
        
        $user->forceDelete();
        
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('username', 'LIKE', "%$search%")->get();
        return view('admin.users', [
            'users'=> $users,
        ]);
    }
}
