<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Expenditure;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index()
    {
        return view('admin.pages.expenditure.index');
    }

    public function saveExpenditure(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
            'expenditure_receipts' => 'required|mimes:pdf|max:2048', // Accept only PDF files, max size 2MB
        ]);

        $expenditure_save_url = null;

        if ($request->hasFile('expenditure_receipts')) {
            $file = $request->file('expenditure_receipts');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $name_gen = $originalName . '_' . time() . '.' . $extension; // Add timestamp for uniqueness
            $file->move(public_path('upload/expenditure'), $name_gen);
            $expenditure_save_url = 'upload/expenditure/' . $name_gen;
        }

        Expenditure::create([
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'user_id' => auth()->id(),
            'expenditure_receipts' => $expenditure_save_url, // Save the file path in the database
        ]);

        Expenditure::updateAccountBalance($request->amount);

        $notification = [
            'message' => 'Expenditure saved successfully.',
            'alert-type' => 'success',
        ];

        return redirect()->route('church-expenditure')->with($notification);
    }

    // public function saveExpenditure(Request $request)
    // {
    //     $request->validate([
    //         'amount' => 'required|numeric|min:0',
    //         'remarks' => 'nullable|string|max:255',
    //     ]);
    //     $expenditure_save_url = $expenditure_receipts;
    //     if ($request->hasFile('expenditure_receipts')) {
    //         $file = $request->file('expenditure_receipts');
    //         $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $extension = $file->getClientOriginalExtension();
    //         $name_gen = $originalName . '.' . $extension;
    //         $file->move(public_path('upload/expenditure'), $name_gen);
    //         $expenditure_save_url = 'upload/expenditure/' . $name_gen;
    //     }
    //     Expenditure::create([
    //         'amount' => $request->amount,
    //         'remarks' => $request->remarks,
    //         'user_id' => auth()->id(),
    //     ]);
    //     Expenditure::updateAccountBalance($request->amount);
    //     $notification = [
    //         'message' => 'Expenditure saved successfully.',
    //         'alert-type' => 'success',
    //     ];
    //     return redirect()->route('church-expenditure')->with($notification);
    // }
    public function Delete($uuid)
    {
        $offering = Expenditure::where('uuid', $uuid)->first();
        if (!$offering) {
            abort(404);
        }
        Expenditure::decrementAccountBalance($offering->amount);
        $offering->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
