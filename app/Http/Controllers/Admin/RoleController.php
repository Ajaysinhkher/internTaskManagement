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
        // Fetch all roles from the database
        $roles = Role::all();
        return view('admin.roles.index',compact('roles'));
    }

    public function create()
    {
    
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'is_super_admin' => 'nullable|boolean',
            'permissions' => 'array',
        ]);

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
    }

    public function destroy($id)
    {
        // Find the role by ID
        $role = Role::findOrFail($id);

        // Check if the role is associated with any admins
        if ($role->admins()->exists()) {
            return redirect()->route('admin.roles.index')->with('error', 'Cannot delete this role as it is assigned to one or more admins.');
        }

        // Delete the role
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
  
}
