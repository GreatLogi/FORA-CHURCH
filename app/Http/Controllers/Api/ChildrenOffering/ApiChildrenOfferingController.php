<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\ChildrenOffering;

use App\Http\Controllers\Controller;
use App\Models\ChildrenOffering;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiChildrenOfferingController extends Controller
{
    public function ChildrenOffering(Request $request)
    {
        $query = ChildrenOffering::with('user')->orderBy('created_at', 'desc');
        $result = DataTables::of($query)
            ->addColumn('user_name', function ($churchoffering) {
                return $churchoffering->user ? $churchoffering->user->name : 'N/A';
            })
            ->addColumn('formatted_amount', function ($churchoffering) {
                $amount = (float) $churchoffering->amount; // Cast to float
                return 'GHS ' . number_format($amount, 2) . ' Pessewa';
            })
            ->addColumn('action', function ($churchoffering) {
                return '<a class="btn btn-sm" href="' . route('children-service-delete', $churchoffering->uuid) . '" title="Delete Data" id="delete">
                        <i class="fa-regular fa-trash-can m-r-5"></i>
                    </a>';
            })
            ->rawColumns(['action'])
            ->make(true);

        return $result;
    }
}
