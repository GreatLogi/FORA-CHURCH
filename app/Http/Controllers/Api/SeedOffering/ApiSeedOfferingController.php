<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\SeedOffering;

use App\Http\Controllers\Controller;
use App\Models\OfferingSeed;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiSeedOfferingController extends Controller
{
    public function OfferingSeed(Request $request)
    {
        $query = OfferingSeed::with('user')->orderBy('created_at', 'desc');
        $result = DataTables::of($query)
            ->addColumn('user_name', function ($offering) {
                return $offering->user ? $offering->user->name : 'N/A';
            })
            ->addColumn('formatted_amount', function ($offering) {
                $amount = (float) $offering->amount;
                return 'GHS ' . number_format($amount, 2) . ' Pessewa';
            })
            ->addColumn('action', function ($offering) {
                return '<a class="btn btn-sm" href="' . route('delete-offering', $offering->uuid) . '" title="Delete Data" id="delete">
                        <i class="fa-regular fa-trash-can m-r-5"></i>
                    </a>';
            })
            ->rawColumns(['action'])
            ->make(true);

        return $result;
    }
}
