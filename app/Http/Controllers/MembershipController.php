<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Membership;
use App\Models\Region;
use App\Models\Tithe;
use App\Models\Tribe;
use Auth;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class MembershipController extends Controller
{
    public function index()
    {
        return view('admin.pages.membership.index');
    }

    public function create()
    {
        $districts = District::all();
        $regions = Region::all();
        $tribes = Tribe::all();
        return view('admin.pages.membership.create', compact('regions', 'districts', 'tribes'));
    }

    public function getRegions($district_id)
    {
        $regions = Region::whereHas('districts', function ($query) use ($district_id) {
            $query->where('id', $district_id);
        })->get();
        return response()->json($regions);
    }

    public function store_data(Request $request)
    {
        $request->validate([
            'lastname' => 'required',
            'first_name' => 'required',
            'phone' => 'required|digits:10',
        ]);

        $save_url = null;

        if ($request->hasFile('member_image')) {
            // Initialize the ImageManager
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('member_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('member_image'));
            $img->resize(200, 200);
            $img->save(public_path('upload/membership/' . $name_gen));

            $save_url = 'upload/membership/' . $name_gen;
        }

        Membership::create([
            'lastname' => $request->lastname,
            'othernames' => $request->othernames,
            'first_name' => $request->first_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'tribe' => $request->tribe,
            'hometown_district' => $request->hometown_district,
            'hometown_region' => $request->hometown_region,
            'educational_background' => $request->educational_background,
            'occupation' => $request->occupation,
            'blood_group' => $request->blood_group,
            'sickcell_type' => $request->sickcell_type,
            'status' => $request->status,
            'title' => $request->title,
            'email' => $request->email,
            'phone' => $request->phone,
            'secondary_phone' => $request->secondary_phone,
            'residential_address' => $request->residential_address,
            'member_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
        ]);

        $notification = [
            'message' => 'Membership Successfully Added',
            'alert-type' => 'success',
        ];

        return redirect()->route('membership-table')->with($notification);
    }
    public function Edit($uuid)
    {
        $member = Membership::where('uuid', $uuid)->first();
        if (!$member) {
            abort(404);
        }
        $districts = District::all();
        $regions = Region::all();
        $tribes = Tribe::all();
        return view('admin.pages.membership.edit', compact('member', 'regions', 'districts', 'tribes'));
    }

    public function Delete($uuid)
    {
        $member = Membership::where('uuid', $uuid)->first();
        if (!$member) {
            abort(404);
        }
        $member->delete();
        $notification = [
            'message' => 'Member Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }

    public function Member_Tithe($uuid)
    {
        $member = Membership::where('uuid', $uuid)->first();
        if (!$member) {
            abort(404);
        }
        return view('admin.pages.membership.tithe.create', compact('member'));
    }
    public function tithe_table()
    {
        return view('admin.pages.membership.tithe.index');
    }
    public function saveTithe(Request $request)
    {
        // Validate the input data
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);
        // Retrieve the member from the database
        $memberId = $request->input('member_id');
        $member = Membership::find($memberId);
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        // Save the tithe record
        Tithe::create([
            'member_id' => $member->id,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'user_id' => auth()->id(),
        ]);
        Tithe::updateAccountBalance($request->amount);
        $notification = [
            'message' => 'Tithe payment saved successfully.',
            'alert-type' => 'success',
        ];
        return redirect()->route('membership-table')->with($notification);
    }

    public function Delete_Tithe($uuid)
    {
        $member = Tithe::where('uuid', $uuid)->first();
        if (!$member) {
            abort(404);
        }
        Tithe::decrementAccountBalance($member->amount);
        $member->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }

}
