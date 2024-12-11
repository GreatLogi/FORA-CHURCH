<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Expenditure;

use App\Http\Controllers\Controller;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiExpenditureController extends Controller
{
    public function apiexpenditure(Request $request)
    {

        $query = Expenditure::with('user')->orderBy('created_at', 'desc');
        $result = DataTables::of($query)
            ->addColumn('user_name', function ($churchexpenditure) {
                return $churchexpenditure->user ? $churchexpenditure->user->name : 'N/A';
            })
            ->addColumn('formatted_amount', function ($churchexpenditure) {
                $amount = (float) $churchexpenditure->amount; // Cast to float
                return 'GHS ' . number_format($amount, 2) . ' Pessewa';
            })
            ->addColumn('action', function ($churchexpenditure) {
                return '<a class="btn btn-sm" href="' . route('delete-expenditure', $churchexpenditure->uuid) . '" title="Delete Data" id="delete">
                        <i class="fa-regular fa-trash-can m-r-5"></i>
                    </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        return $result;
    }
}
