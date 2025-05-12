<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        try{
            $users = User::all();
            return view('admin.users.index', compact('users'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading users: ' . $e->getMessage());
        }
    }

    public function create(){
        try{
            return view('admin.users.create');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error accessing create user page: ' . $e->getMessage());
        }
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            User::create($request->all());
            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    public function edit($id){
        try{
            $user = User::findOrFail($id);
            return view('admin.users.edit', compact('user'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error accessing edit user page: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $user->update($request->all());
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }
    
    public function destroy($id){
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}
