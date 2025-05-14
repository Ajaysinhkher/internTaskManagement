<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str; 

class RoleController extends Controller
{
   
    public function index()
    {

        try{

            // Fetch all roles from the database
            $roles = Role::all();
            return view('admin.roles.index',compact('roles'));

        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading roles: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try{
            
            $permissions = Permission::all();
            return view('admin.roles.create',compact('permissions'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error accessing create role page: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'is_super_admin' => 'nullable|boolean',
            'permissions' => 'array',
        ]);


        try{

            // Create a new role  
            $role = Role::create([
                'name' => $request->name,
                'slug'=> Str::slug($request->name),
             
                'is_super_admin' => $request->has('is_super_admin') && $request->is_super_admin == '1' ? true : false,
            ]);
            
             // If super admin, assign all permissions
            if ($role->is_super_admin) {
                $allPermissionIds = Permission::pluck('id')->toArray();
                $role->permissions()->sync($allPermissionIds);
            }
            // Otherwise, attach selected permissions
            elseif ($request->permissions) {
                $role->permissions()->sync($request->permissions);
            }
            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
            
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating role: ' . $e->getMessage());
        }

    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('id', 'permissions','role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_super_admin' => 'nullable|boolean',
            'permissions' => 'array',
        ]);


        try{
            // Find the role by ID
            $role = Role::findOrFail($id);
    
            // Update the role
            $role->update([
                'name' => $request->name,
                'slug'=> Str::slug($request->name),
                'is_super_admin' => $request->has('is_super_admin') && $request->is_super_admin == '1' ? true : false,
            ]);
    
            // If super admin, assign all permissions
            if ($role->is_super_admin) {
                $allPermissionIds = Permission::pluck('id')->toArray();
                $role->permissions()->sync($allPermissionIds);
            }
            // Otherwise, sync selected permissions
            elseif ($request->permissions) {
                $role->permissions()->sync($request->permissions);
            }
            // No permissions provided and not super admin: detach all
            else {
                $role->permissions()->detach();
            }
    
            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating role: ' . $e->getMessage());
        }   
    }



    public function destroy($id)
    {

        try{
            // Find the role by ID
            $role = Role::findOrFail($id);
    
            // Check if the role is associated with any admins
            if ($role->admins()->exists()) {
                return redirect()->route('admin.roles.index')->with('error', 'Cannot delete this role as it is assigned to one or more admins.');
            }
    
            // Delete the role
            $role->delete();
    
            return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');

        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting role: ' . $e->getMessage());
        }
    }
  
}
