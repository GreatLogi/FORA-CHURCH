<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        return view('admin.pages.systemsetting.roles.index');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'nullable|string|max:255',
        ]);

        // Create the role using Spatie's Role model
        Role::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'] ?? 'web',
        ]);

        return redirect()->back()->with('success', 'Role created successfully.');
    }

    public function store_permission(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'role_ids' => 'required|array', // Validate that at least one role is selected
            'role_ids.*' => 'exists:roles,id', // Validate that the selected role IDs exist
            'permissions_input' => 'nullable|string', // Validate the manual permission input (comma-separated)
            'permissions' => 'array', // For existing permissions selected by checkbox
            'permissions.*' => 'exists:permissions,id', // Validate that the permission IDs exist
            'guard_name' => 'nullable|string|max:255', // Validate the guard_name (optional)
        ]);

        // Loop through each selected role
        foreach ($validated['role_ids'] as $roleId) {
            $role = Role::find($roleId);

            // Handle existing permissions selected via checkboxes
            if (!empty($validated['permissions'])) {
                foreach ($validated['permissions'] as $permissionId) {
                    $permission = Permission::find($permissionId);

                    // Assign the permission to the role using Spatie's model_has_permission
                    $role->givePermissionTo($permission);
                }
            }

            // Handle manual permissions input (if any)
            if (!empty($validated['permissions_input'])) {
                // Split the permissions input by commas
                $permissions = explode(',', $validated['permissions_input']);
                $permissions = array_map('trim', $permissions); // Remove any extra spaces

                // Loop through each permission and create or find it
                foreach ($permissions as $permissionName) {
                    // Check if guard_name is provided; use default if not
                    $guardName = $validated['guard_name'] ?? 'web';

                    // Create or find the permission with both name and guard_name
                    $permission = Permission::firstOrCreate(
                        ['name' => $permissionName, 'guard_name' => $guardName]
                    );

                    // Assign the permission to the role using Spatie's model_has_permission
                    $role->givePermissionTo($permission);
                }
            }
        }

        return redirect()->back()->with('success', 'Permissions successfully assigned to the roles.');
    }

}
