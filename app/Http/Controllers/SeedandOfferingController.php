<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\OfferingSeed;
use Illuminate\Http\Request;

class SeedandOfferingController extends Controller
{
    public function index()
    {
        return view('admin.pages.seedandoffering.index');
    }

    public function saveOffering(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);
        OfferingSeed::create([
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'user_id' => auth()->id(),
        ]);
        OfferingSeed::updateAccountBalance($request->amount);
        $notification = [
            'message' => 'Offering saved successfully.',
            'alert-type' => 'success',
        ];
        return redirect()->route('church-offering')->with($notification);
    }

    public function Delete($uuid)
    {
        $offering = OfferingSeed::where('uuid', $uuid)->first();
        if (!$offering) {
            abort(404);
        }
        OfferingSeed::decrementAccountBalance($offering->amount);
        $offering->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
