<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ChildrenOfferingController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\LoginandLogoutController;
use App\Http\Controllers\ManageUserAccountController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SeedandOfferingController;
use App\Http\Controllers\UserAccountController;
use App\Models\Account;
use App\Models\ChildrenOffering;
use App\Models\Expenditure;
use App\Models\Membership;
use App\Models\OfferingSeed;
use App\Models\Tithe;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
});
Route::post('login', [LoginandLogoutController::class, 'Log_in'])->name('user.login');
Route::get('logout', [LoginandLogoutController::class, 'Logout'])->name('logout-user')
    ->middleware('auth');

Route::get('/reset-password', [LoginandLogoutController::class, 'resetpassword'])->name('reset-password');

Route::get('/verify/otp', [OTPController::class, 'showVerifyOtpForm'])->name('verify.otp');
Route::post('/verify/otp', [OTPController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [OTPController::class, 'resendOtp'])->name('otp.resend');

Route::post('/forgot-password-reset', [LoginandLogoutController::class, 'forgotPassword'])->name('forgot-password-reset');
Route::post('/password-changed', [ManageUserAccountController::class, 'changePassword'])->name('changed-password');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified', 'otp', 'force.password.change',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         $total_mem = Membership::count();
//         $total_mem_male = Membership::where('gender', 'MALE')->count();
//         $total_mem_female = Membership::where('gender', 'FEMALE')->count();
//         $total_users = User::count();
//         return view('admin.index', compact('total_mem', 'total_mem_male', 'total_mem_female', 'total_users'));
//     })->name('dashboard');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'otp',
    'force.password.change',
])->group(function () {
    Route::get('/dashboard', function () {
        $total_mem = Membership::count();
        $total_mem_male = Membership::where('gender', 'MALE')->count();
        $total_mem_female = Membership::where('gender', 'FEMALE')->count();
        $total_users = User::count();
        $account_balance = Account::first()->balance;
        $total_expenditure = Expenditure::sum('amount');
        $currentDate = now();
        $totals = [
            'tithe' => ['week' => 0.00, 'month' => 0.00, 'year' => 0.00],
            'offering' => ['week' => 0.00, 'month' => 0.00, 'year' => 0.00],
            'children_offering' => ['week' => 0.00, 'month' => 0.00, 'year' => 0.00],
            'expenditure' => ['week' => 0.00, 'month' => 0.00, 'year' => 0.00],
        ];
        try {
            $totals = [
                'tithe' => [
                    'week' => Tithe::whereBetween('created_at', [
                        $currentDate->copy()->startOfWeek(\Carbon\Carbon::SUNDAY),
                        $currentDate->copy()->endOfWeek(\Carbon\Carbon::SATURDAY),
                    ])->sum('amount') ?? 0.00,
                    'month' => Tithe::whereYear('created_at', $currentDate->year)->whereMonth('created_at', $currentDate->month)->sum('amount') ?? 0.00,
                    'year' => Tithe::whereYear('created_at', $currentDate->year)->sum('amount') ?? 0.00,
                ],
                'offering' => [
                    'week' => OfferingSeed::whereBetween('created_at', [
                        $currentDate->copy()->startOfWeek(\Carbon\Carbon::SUNDAY),
                        $currentDate->copy()->endOfWeek(\Carbon\Carbon::SATURDAY),
                    ])->sum('amount') ?? 0.00,
                    'month' => OfferingSeed::whereYear('created_at', $currentDate->year)->whereMonth('created_at', $currentDate->month)->sum('amount') ?? 0.00,
                    'year' => OfferingSeed::whereYear('created_at', $currentDate->year)->sum('amount') ?? 0.00,
                ],
                'children_offering' => [
                    'week' => ChildrenOffering::whereBetween('created_at', [
                        $currentDate->copy()->startOfWeek(\Carbon\Carbon::SUNDAY),
                        $currentDate->copy()->endOfWeek(\Carbon\Carbon::SATURDAY),
                    ])->sum('amount') ?? 0.00,
                    'month' => ChildrenOffering::whereYear('created_at', $currentDate->year)->whereMonth('created_at', $currentDate->month)->sum('amount') ?? 0.00,
                    'year' => ChildrenOffering::whereYear('created_at', $currentDate->year)->sum('amount') ?? 0.00,
                ],
                'expenditure' => [
                    'week' => Expenditure::whereBetween('created_at', [
                        $currentDate->copy()->startOfWeek(\Carbon\Carbon::SUNDAY),
                        $currentDate->copy()->endOfWeek(\Carbon\Carbon::SATURDAY),
                    ])->sum('amount') ?? 0.00,
                    'month' => Expenditure::whereYear('created_at', $currentDate->year)->whereMonth('created_at', $currentDate->month)->sum('amount') ?? 0.00,
                    'year' => Expenditure::whereYear('created_at', $currentDate->year)->sum('amount') ?? 0.00,
                ],
            ];

        } catch (\Exception $e) {
            \Log::error('Error fetching financial totals: ' . $e->getMessage());
        }
        return view('admin.index', compact(
            'total_mem',
            'total_mem_male',
            'total_mem_female',
            'total_users',
            'totals',
            'account_balance',
            'total_expenditure'
        ));
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [LoginandLogoutController::class, 'verifyaccount'])->name('verify-password');

    Route::prefix('membership')->group(function () {
        Route::get('/fora-members', [MembershipController::class, 'index'])->name('membership-table');
        Route::get('/mech-membership', [MembershipController::class, 'create'])->name('mech-membership');
        Route::get('/get-regions/{district_id}', [MembershipController::class, 'getRegions'])->name('get-regions');
        Route::post('/membership/update/{uuid}', [MembershipController::class, 'update'])->name('update-membership');
        Route::post('/save-membership', [MembershipController::class, 'store_data'])->name('save-membership');
        Route::get('/edit-membership-{uuid}', [MembershipController::class, 'Edit'])->name('edit-membership');
        Route::get('/delete-membership{uuid}', [MembershipController::class, 'Delete'])->name('delete-membership');

        Route::get('/member-tithe-{uuid}', [MembershipController::class, 'Member_Tithe'])->name('member-tithe');
        Route::post('/save-tithe', [MembershipController::class, 'saveTithe'])->name('save-tithe');
        Route::get('/fora-members-tithes-payment', [MembershipController::class, 'tithe_table'])->name('members-tithe-table');
        Route::get('/delete-member-tithe-{uuid}', [MembershipController::class, 'Delete_Tithe'])->name('delete-member-tithe');
    });
    Route::prefix('Offering')->group(function () {
        Route::get('/', [SeedandOfferingController::class, 'index'])->name('church-offering');
        Route::post('/save-offering', [SeedandOfferingController::class, 'saveOffering'])->name('save-offering');
        Route::get('/offering/{uuid}', [SeedandOfferingController::class, 'Delete'])->name('delete-offering');
    });
    Route::prefix('Children-Service-Offering')->group(function () {
        Route::get('/', [ChildrenOfferingController::class, 'index'])->name('children-service-offering');
        Route::post('/save-offering', [ChildrenOfferingController::class, 'saveChildrenOffering'])->name('save-children-service');
        Route::get('/offering/{uuid}', [ChildrenOfferingController::class, 'Delete'])->name('children-service-delete');
    });
    Route::prefix('Account-Balance')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('account-balance');
    });
    Route::prefix('Expenditure')->group(function () {
        Route::get('/', [ExpenditureController::class, 'index'])->name('church-expenditure');
        Route::post('/save-offering', [ExpenditureController::class, 'saveExpenditure'])->name('save-expenditure');
        Route::get('/offering/{uuid}', [ExpenditureController::class, 'Delete'])->name('delete-expenditure');
    });
    Route::prefix('districts')->group(function () {
        Route::get('/', [DistrictController::class, 'View'])->name('districts');
        Route::post('/view-districts', [DistrictController::class, 'index'])->name('view-region-district');
        Route::get('/edit-districts-{uuid}', [DistrictController::class, 'Edit'])->name('edit-districts');
        Route::get('/delete-districts-{uuid}', [DistrictController::class, 'Delete'])->name('delete-districts');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserAccountController::class, 'index'])->name('index-user');
        Route::get('/user-logins-times', [UserAccountController::class, 'user_login_times'])->name('user-login-times');
        Route::get('/audit-trail', [UserAccountController::class, 'audit_trail'])->name('audit-trail');
        Route::get('/add', [UserAccountController::class, 'create'])->name('create-user');
        Route::post('/store', [UserAccountController::class, 'store'])->name('store-user');
        Route::get('/edit/{uuid}', [UserAccountController::class, 'edit'])->name('edit-user');
        Route::post('/user/update/{uuid}', [UserAccountController::class, 'update'])->name('update-user');
        Route::get('/delete{uuid}', [UserAccountController::class, 'destroy'])->name('destroy-user');
        Route::get('/inactivation-{uuid}', [UserAccountController::class, 'Active'])->name('user-inactive');
        Route::get('/activation-{uuid}', [UserAccountController::class, 'Inactive'])->name('user-active');
    });
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('create-roles');
        Route::post('/roles/store', [RolesController::class, 'store'])->name('store-role');
        Route::post('/roles/permissions/store', [RolesController::class, 'store_permission'])->name('store-role-permission');
    });
});

// Route::get('/change-password', [LoginandLogoutController::class, 'verifyaccount'])->name('verify-password');
// Route::prefix('membership')->group(function () {
//     Route::get('/fora-members', [MembershipController::class, 'index'])->name('membership-table');
//     Route::get('/mech-membership', [MembershipController::class, 'create'])->name('mech-membership');
//     Route::get('/get-regions/{district_id}', [MembershipController::class, 'getRegions'])->name('get-regions');
//     Route::post('/membership/update/{uuid}', [MembershipController::class, 'update'])->name('update-membership');
//     Route::post('/save-membership', [MembershipController::class, 'store_data'])->name('save-membership');
//     Route::get('/edit-membership-{uuid}', [MembershipController::class, 'Edit'])->name('edit-membership');
//     Route::get('/delete-membership{uuid}', [MembershipController::class, 'Delete'])->name('delete-membership');
// });
// Route::prefix('districts')->group(function () {
//     Route::get('/', [DistrictController::class, 'View'])->name('districts');
//     Route::post('/view-districts', [DistrictController::class, 'index'])->name('view-region-district');
// });
