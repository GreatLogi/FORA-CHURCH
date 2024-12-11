<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MemberDataController extends Controller
{
    public function memembers(Request $request)
    {
        // Query Membership model with relationships
        $query = Membership::with(['tribes', 'home_districts', 'hometown_regions'])->orderBy('created_at', 'desc');
        // Use DataTables to format the results
        $result = DataTables::of($query)
            ->addColumn('age', function ($record) {
                if ($record->dob) {
                    $dob = Carbon::parse($record->dob);
                    $now = Carbon::now();
                    $ageDifference = $dob->diff($now);

                    return sprintf(
                        '%d years %d months %d days',
                        $ageDifference->y,
                        $ageDifference->m,
                        $ageDifference->d
                    );
                }
                return 'N/A';
            })
            ->addColumn('image', function ($record) {
                // Return the uploaded image or the default image
                $imagePath = $record->member_image
                ? asset($record->member_image)
                : asset('membership_profile.png');
                return '<img src="' . $imagePath . '" alt="Member Image" width="50" height="50" class="img-thumbnail">';
            })
            ->addColumn('tribe_name', function ($record) {
                return $record->tribes ? $record->tribes->name : 'N/A';
            })
            ->addColumn('district_name', function ($record) {
                return $record->home_districts ? $record->home_districts->district_name : 'N/A';
            })
            ->addColumn('region_name', function ($record) {
                return $record->hometown_regions ? $record->hometown_regions->region_name : 'N/A';
            })
            ->addColumn('action', function ($record) {
                return '
                    <a href="#" class="action-icon" onclick="showActionPopup(event, \'' . $record->uuid . '\')">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <div id="action-popup-' . $record->uuid . '" class="action-popup" style="display: none;">
                        <ul>
                            <li>
                                <a href="' . route('edit-membership', $record->uuid) . '">
                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a href="' . route('member-tithe', $record->uuid) . '">
                                    <i class="fa-solid fa-pencil m-r-5"></i> Tithe
                                </a>
                            </li>
                            <li>
                                <a href="' . route('delete-membership', $record->uuid) . '" id="delete">
                                    <i class="fa-regular fa-trash-can m-r-5"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
            })

            ->rawColumns(['image', 'action'])
            ->make(true);

        return $result;
    }

}
