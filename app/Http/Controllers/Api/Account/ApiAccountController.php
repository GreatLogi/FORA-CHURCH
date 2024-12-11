<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApiAccountController extends Controller
{
    public function Account(Request $request)
    {
        $query = Account::query();
        $result = DataTables::of($query)
            ->addColumn('formatted_amount', function ($balanceoffering) {
                $balance = (float) $balanceoffering->balance;
                return 'GHS ' . number_format($balance, 2) . ' Pessewa';
            })
            ->make(true);
        return $result;
    }
}
