<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // Define available permissions (you can move this to config if needed)
    private $permissions = [
        'user_index', 'user_create', 'user_edit', 'user_delete',
        'manage_roles', 'manage_permissions',
        'page_index', 'page_create', 'page_edit', 'page_delete',
        'slider_index', 'slider_edit', 'slider_delete', 'slider_create',
        'block_edit', 'block_delete', 'block_create', 'block_index',
        'enquiry',
        'product_index', 'product_create', 'product_delete', 'product_edit', 'product_show',
        'category_index', 'category_create', 'category_delete', 'category_edit', 'category_show',
        'attribute_index', 'attribute_create', 'attribute_show', 'attribute_delete', 'attribute_edit',
        'manage_orders',
        'coupon_index', 'coupon_create', 'coupon_edit', 'coupon_delete',
        'manage_customers'
    ];

    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::latest()->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return view('admin.roles.create', [
            'allPermissions' => $this->permissions
        ]);
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'permission' => 'nullable|array',
        ]);

        Role::create([
            'role_name' => $request->role_name,
            'permission' => is_array($request->permission) ? implode(',', $request->permission) : '',
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $selectedPermissions = explode(',', $role->permission);

        return view('admin.roles.edit', [
            'role' => $role,
            'allPermissions' => $this->permissions,
            'selectedPermissions' => $selectedPermissions
        ]);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'permission' => 'nullable|array',
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'role_name' => $request->role_name,
            'permission' => is_array($request->permission) ? implode(',', $request->permission) : '',
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
