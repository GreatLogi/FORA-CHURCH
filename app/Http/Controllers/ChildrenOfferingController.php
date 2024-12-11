<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\ChildrenOffering;
use Illuminate\Http\Request;

class ChildrenOfferingController extends Controller
{
    public function index()
    {
        return view('admin.pages.childrenoffering.index');
    }

    public function saveChildrenOffering(Request $request)
    {
        // Validate the input data
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);
        ChildrenOffering::create([
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'user_id' => auth()->id(),
        ]);
        ChildrenOffering::updateAccountBalance($request->amount);
        $notification = [
            'message' => 'Children Offering saved successfully.',
            'alert-type' => 'success',
        ];
        return redirect()->route('children-service-offering')->with($notification);
    }
    public function Delete($uuid)
    {
        $offering = ChildrenOffering::where('uuid', $uuid)->first();
        if (!$offering) {
            abort(404);
        }
        ChildrenOffering::decrementAccountBalance($offering->amount);
        $offering->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
