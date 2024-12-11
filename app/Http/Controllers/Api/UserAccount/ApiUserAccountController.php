<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\UserAccount;

use App\Http\Controllers\Controller;
use App\Models\activityLog;
use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiUserAccountController extends Controller
{

    public function getUsers(Request $request)
    {
        $users = User::with('roles')->get();
        return DataTables::of($users)
            ->addColumn('created_at', function ($user) {
                return $user->created_at
                ? $user->created_at->format('d M, Y h:i A')
                : '';
            })
            ->addColumn('status', function ($user) {
                if ($user->status == 1) {
                    // Active Status
                    return '<a href="' . route('user-inactive', $user->uuid) . '"
                                class="badge bg-inverse-success"
                                title="Active"
                                id="ActiveBtn">Active</a>';
                } else if ($user->status == 0) {
                    // Inactive Status
                    return '<a href="' . route('user-active', $user->uuid) . '"
                                class="badge bg-inverse-danger"
                                title="Inactive"
                                id="InactiveBtn">Inactive</a>';
                }
            })
            ->addColumn('action', function ($user) {
                return '<a class="btn btn-sm" href="' . route('edit-user', $user->uuid) . '">
                            <i class="fa-solid fa-pencil m-r-5"></i>
                        </a>
                        <a class="btn btn-sm" href="' . route('destroy-user', $user->uuid) . '" title="Delete Data" id="delete">
                            <i class="fa-regular fa-trash-can m-r-5"></i>
                        </a>';
            })
            ->addColumn('roles', function ($user) {
                // Display each role as a badge
                return $user->roles->pluck('name')->map(function ($role) {
                    return '<span class="badge bg-primary" style="color: white;">' . $role . '</span>';
                })->implode(' ');
            })
            ->rawColumns(['status', 'action', 'roles']) // Render HTML for the status and action columns
            ->make(true);
    }

    public function getLogActives(Request $request)
    {
        $users = activityLog::query();

        return DataTables::of($users)
            ->addColumn('date_time', function ($user) {
                return $user->date_time
                ? \Carbon\Carbon::parse($user->date_time)->format('d M, Y h:i A')
                : '';
            })
            ->make(true);
    }

    public function getAudit(Request $request)
    {
        // Eager load the 'user' relationship
        $audits = Audit::with('user')->get();

        return DataTables::of($audits)
            ->addColumn('created_at', function ($audit) {
                return $audit->created_at ? $audit->created_at->format('d M, Y h:i A') : '';
            })
            ->addColumn('user', function ($audit) {
                // Safely check if the user relationship exists and return the user's name
                return $audit->user ? $audit->user->name : 'N/A';
            })
            ->rawColumns(['user']) // Ensure that the 'user' column is treated as raw content
            ->make(true);
    }

}
