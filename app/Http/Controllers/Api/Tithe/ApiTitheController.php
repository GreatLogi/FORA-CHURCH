<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Tithe;

use App\Http\Controllers\Controller;
use App\Models\Tithe;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiTitheController extends Controller
{
    public function memember_tithe(Request $request)
    {
        // Query Tithe model with relationships
        $query = Tithe::with(['member', 'user'])->orderBy('created_at', 'desc'); // Ensure relationships are correctly defined in the Tithe model
        // Use DataTables to format the results
        $result = DataTables::of($query)
            ->addColumn('member_name', function ($tithe) {
                return $tithe->member
                ? $tithe->member->lastname . ' ' . $tithe->member->first_name . ' ' . $tithe->member->othernames
                : 'N/A';
            })
            ->addColumn('user_name', function ($tithe) {
                return $tithe->user ? $tithe->user->name : 'N/A'; // Assuming the 'name' column exists in the User model
            })
            ->addColumn('formatted_amount', function ($tithe) {
                $amount = (float) $tithe->amount; // Cast to float
                return 'GHS ' . number_format($amount, 2) . ' Pessewa';
            })

            ->addColumn('action', function ($tithe) {
                return '<a class="btn btn-sm" href="' . route('delete-member-tithe', $tithe->uuid) . '" title="Delete Data" id="delete">
                        <i class="fa-regular fa-trash-can m-r-5"></i>
                    </a>';
            })
            ->rawColumns(['action'])
            ->make(true);

        return $result;
    }
}
