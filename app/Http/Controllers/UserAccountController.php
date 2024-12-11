<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAccountController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Cache the roles and permissions data for a period of time
        $roles = Cache::remember('roles', 60, function () {
            return Role::with('permissions:id,name')->get(['id', 'name', 'guard_name']);
        });

        $permissions = Cache::remember('permissions', 60, function () {
            return Permission::all(['id', 'name']);
        });

        $rolesWithPermissions = $roles->mapWithKeys(function ($role) {
            return [$role->id => $role->permissions->pluck('id')->toArray()];
        });

        return view('admin.pages.systemsetting.users.index', compact('roles', 'permissions', 'rolesWithPermissions'));
    }

    public function user_login_times()
    {
        return view('admin.pages.systemsetting.users.loginact');
    }
    public function audit_trail()
    {
        return view('admin.pages.systemsetting.users.audit');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('useraccount.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any user !');
        }
        $roles = Role::all();
        return view('systemsetting.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'name' => 'required|max:50|unique:users',
            'email' => 'required|max:100|email|unique:users',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Create New Admin
        $user = new User();
        $code = rand(0000, 9999);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = '1';
        $user->password = bcrypt($code);
        $user->code = $code;
        $user->phone_number = $request->phone_number;
        $user->save();

        if ($request->has('roles')) {
            foreach ($request->roles as $roleId) {
                // Check if the role exists before assigning
                $role = Role::find($roleId);
                if ($role) {
                    $user->assignRole($role);
                } else {
                    // Handle invalid role assignment
                    return redirect()->back()->withErrors('Role ID ' . $roleId . ' does not exist.');
                }
            }
        }

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permissionId) {
                // Check if the permission exists before assigning
                $permission = Permission::find($permissionId);
                if ($permission) {
                    $user->givePermissionTo($permission);
                } else {
                    // Handle invalid permission assignment
                    return redirect()->back()->withErrors('Permission ID ' . $permissionId . ' does not exist.');
                }
            }
        }
        session()->flash('success', 'User has been created !!');
        return redirect()->route('index-user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        // if (is_null($this->user) || !$this->user->can('useraccount.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        // }
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        $roles = Cache::remember('roles', 60, function () {
            return Role::with('permissions:id,name')->get(['id', 'name', 'guard_name']);
        });

        $permissions = Cache::remember('permissions', 60, function () {
            return Permission::all(['id', 'name']);
        });

        $rolesWithPermissions = $roles->mapWithKeys(function ($role) {
            return [$role->id => $role->permissions->pluck('id')->toArray()];
        });
        return view('admin.pages.systemsetting.users.edit', compact('user', 'roles', 'permissions', 'rolesWithPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        // Validate inputs
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $user->id,
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*.*' => 'exists:permissions,id',
        ]);
        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->save();
        // Convert role IDs to role names
        $roles = [];
        if ($request->has('roles')) {
            $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
        }
        $user->syncRoles($roles);
        // Convert permission IDs to permission names
        $permissions = [];
        if ($request->has('permissions')) {
            foreach ($request->permissions as $rolePermissions) {
                $permissionNames = Permission::whereIn('id', $rolePermissions)->pluck('name')->toArray();
                $permissions = array_merge($permissions, $permissionNames);
            }
        }
        $user->syncPermissions($permissions);
        session()->flash('success', 'User updated successfully!');
        return redirect()->route('index-user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        // if (is_null($this->user) || !$this->user->can('useraccount.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        // }
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        $user->delete();
        session()->flash('success', 'User has been deleted !!');
        return back();
    }

    public function Inactive($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        if ($user) {
            $user->status = 1;
            $user->save();
            $notification = [
                'message' => 'Changed Made Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('index-user')->with($notification);
        }
    }

    public function Active($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        if ($user) {
            $user->status = 0;
            $user->save();
            $notification = [
                'message' => 'Change Made Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('index-user')->with($notification);
        }
    }
}
