<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
    public function index()
    {

        try{

            $admins = Admin::all();
            return view('admin.admins.index',compact('admins'));

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function create()
    {
        try{

            $roles = Role::all();
            return view('admin.admins.create',compact('roles'));
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);


        try{

            // Create a new admin
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
            ]);
    
            return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong!');
        }

    }

    public function edit($id)
    {

        try{

            $admin = Admin::findOrFail($id);
            $roles = Role::all();
            return view('admin.admins.edit', compact('id','admin','roles'));
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function update(Request $request, $id)
    {
      $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        try{

            $admin = Admin::findOrFail($id);
            $admin->name = $request->name;
            $admin->email = $request->email;
    
            if ($request->password) {
                $admin->password = bcrypt($request->password);
            }
    
            $admin->role_id = $request->role_id;
            $admin->save();
    
            return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong!');
        }

    }

    public function destroy($id)
    {

        try{

            $admin = Admin::findOrFail($id);
            $admin->delete();
             return redirect()->route('admin.admins.index')->with('success', 'Role deleted successfully.');

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
