<?php

use App\Http\Controllers\Api\Account\ApiAccountController;
use App\Http\Controllers\Api\ChildrenOffering\ApiChildrenOfferingController;
use App\Http\Controllers\Api\Expenditure\ApiExpenditureController;
use App\Http\Controllers\Api\Membership\MemberDataController;
use App\Http\Controllers\Api\SeedOffering\ApiSeedOfferingController;
use App\Http\Controllers\Api\Tithe\ApiTitheController;
use App\Http\Controllers\Api\UserAccount\ApiUserAccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::prefix('api')->group(function () {
    Route::post('/api-view-members', [MemberDataController::class, 'memembers'])->name('api-view-members');
    Route::post('/api-view-user', [ApiUserAccountController::class, 'getUsers'])->name('api-view-user');
    Route::post('/api-user-login-times', [ApiUserAccountController::class, 'getLogActives'])->name('api-user-login-times');
    Route::post('/api-audit-trail', [ApiUserAccountController::class, 'getAudit'])->name('api-audit-trail');
    Route::post('/api-members-tithes', [ApiTitheController::class, 'memember_tithe'])->name('api-members-tithes');

    Route::post('/api-seed-and-offering', [ApiSeedOfferingController::class, 'OfferingSeed'])->name('api-seed-and-offering');
    Route::post('/api-children-service-offering', [ApiChildrenOfferingController::class, 'ChildrenOffering'])->name('api-children-service-offering');

    Route::post('/api-balance', [ApiAccountController::class, 'Account'])->name('api-balance');
    Route::post('/api-church-expenditure', [ApiExpenditureController::class, 'apiexpenditure'])->name('api-church-expenditure');

});
