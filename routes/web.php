<?php

use App\Http\Controllers\Admin\HmController as AdminHmController;
use App\Http\Controllers\CompanyAdmin\CompanyUsersController;
use App\Http\Controllers\Hm\HmController;
use App\Http\Controllers\Investigator\CompanyAdminsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyAdminController as AdminCompanyController;
use App\Http\Controllers\Admin\InvestigatorController as AdminInvestigatorController;
use App\Http\Controllers\CompanyAdmin\CompanyAdminController;
use App\Http\Controllers\Investigator\InvestigatorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $title = 'ILOGISTIC Portal | Login';
    return view('auth.login', compact('title'));
});

Auth::routes();
// Users Routes

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/my-profile', [AdminController::class, 'myProfile'])->name('my-profile');
    Route::get('/reset-password', [AdminController::class, 'adminResetPassword'])->name('reset-password');
    Route::post('/update-password', [AdminController::class, 'adminPasswordUpdate'])->name('update-password');
    Route::post('/profile/update', [AdminController::class, 'adminProfileUpdate'])->name('profile.update');

    Route::group(['prefix' => 'company-admins', 'as' => 'company-admins.'], function () {
        Route::get('/', [AdminCompanyController::class, 'index'])->name('index');
        Route::get('/add', [AdminCompanyController::class, 'view'])->name('add');
        Route::post('/submit', [AdminCompanyController::class, 'store'])->name('submit');
        Route::get('/delete/{id}', [AdminCompanyController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [AdminCompanyController::class, 'edit'])->name('edit');
        Route::get('/reset-password/{id}', [AdminCompanyController::class, 'resetPassword'])
            ->name('reset-password');
        Route::post('/update-password', [AdminCompanyController::class, 'passwordUpdate'])
            ->name('update-password');
        Route::get('/{id}/view', [AdminCompanyController::class, 'viewProfile'])->name('view');
    });

    Route::group(['prefix' => 'hiring-managers', 'as' => 'hiring-managers.'], function () {
        Route::get('/', [AdminHmController::class, 'index'])->name('index');
        Route::get('/add', [AdminHmController::class, 'view'])->name('add');
        Route::post('/submit', [AdminHmController::class, 'store'])->name('submit');
        Route::get('/delete/{id}', [AdminHmController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [AdminHmController::class, 'edit'])->name('edit');
        Route::get('/reset-password/{id}', [AdminHmController::class, 'resetPassword'])
            ->name('reset-password');
        Route::post('/update-password', [AdminHmController::class, 'passwordUpdate'])
            ->name('update-password');
    });

    Route::group(['prefix' => 'investigators', 'as' => 'investigators.'], function () {
        Route::get('/', [AdminInvestigatorController::class, 'index'])->name('index');
        Route::get('/add', [AdminInvestigatorController::class, 'view'])->name('add');
        Route::post('/submit', [AdminInvestigatorController::class, 'store'])->name('submit');
        Route::get('/delete/{id}', [AdminInvestigatorController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [AdminInvestigatorController::class, 'edit'])->name('edit');
        // Route::get('/reset-password/{id}', [AdminInvestigatorController::class, 'investigatorResetPassword'])->name('reset-password');
        Route::get('/reset-password/{id}', [AdminInvestigatorController::class, 'investigatorResetPassword'])->name('reset-password');
        Route::post('/update-password', [AdminInvestigatorController::class, 'investigatorResetUpdate'])->name('update-password');
        Route::get('/{id}/view', [AdminInvestigatorController::class, 'profileView'])->name('view');
    });

});

Route::group(['prefix' => 'company-admin', 'as' => 'company-admin.', 'middleware' => ['company-admin']], function () {
    Route::get('/', [CompanyAdminController::class, 'index'])->name('index');
    Route::get('/profile', [CompanyAdminController::class, 'viewProfile'])->name('profile');
    Route::get('/find-investigators', [CompanyAdminController::class, 'findInvestigator'])->name('find_investigator');
    Route::post('/profile/submit', [CompanyAdminController::class, 'store'])->name('profile.submit');
    Route::get('/my-profile', [CompanyAdminController::class, 'myProfile'])->name('my-profile');
    Route::get('/reset-password', [CompanyAdminController::class, 'companyResetPassword'])
        ->name('reset-password');
    Route::post('/update-password', [CompanyAdminController::class, 'companyPasswordUpdate'])
        ->name('update-password');
    Route::post('/my-profile/update', [CompanyAdminController::class, 'companyProfileUpdate'])
        ->name('profile.update');
    Route::get('/view-profile', [CompanyAdminController::class, 'companyProfile'])->name('view');


    Route::group(['prefix' => 'company-users', 'as' => 'company-users.'], function () {
        Route::get('/', [CompanyUsersController::class, 'index'])->name('index');
        Route::get('/add', [CompanyUsersController::class, 'view'])->name('add');
        Route::post('/submit', [CompanyUsersController::class, 'store'])->name('submit');
        Route::get('/delete/{id}', [CompanyUsersController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [CompanyUsersController::class, 'edit'])->name('edit');
        Route::get('/reset-password/{id}', [CompanyUsersController::class, 'resetPassword'])
            ->name('reset-password');
        Route::post('/update-password', [CompanyUsersController::class, 'passwordUpdate'])
            ->name('update-password');
    });
});

Route::group(['prefix' => 'hm', 'as' => 'hm.', 'middleware' => ['hm']], function () {
    Route::get('/', [HmController::class, 'index'])->name('index');
    Route::get('/company-users', [HmController::class, 'companyUsers'])->name('company-users.index');
    Route::get('/profile', [HmController::class, 'viewProfile'])->name('profile');
    Route::get('/find-investigators', [CompanyAdminController::class, 'findInvestigator'])->name('find_investigator');
    Route::post('/profile/submit', [HmController::class, 'store'])->name('profile.submit');
    Route::get('/my-profile', [HmController::class, 'myProfile'])->name('my-profile');
    Route::get('/reset-password', [HmController::class, 'hmResetPassword'])
        ->name('reset-password');
    Route::post('/update-password', [HmController::class, 'hmPasswordUpdate'])
        ->name('update-password');
    Route::post('/my-profile/update', [HmController::class, 'hmProfileUpdate'])
        ->name('profile.update');
    Route::get('/view-profile', [HmController::class, 'companyProfile'])->name('view');
});

Route::group(['prefix' => 'investigator', 'as' => 'investigator.', 'middleware' => ['investigator']], function () {
    Route::get('/', [InvestigatorController::class, 'index'])->name('index');
    Route::get('/profile', [InvestigatorController::class, 'viewProfile'])->name('profile');
    Route::get('/view', [InvestigatorController::class, 'view'])->name('view');
    Route::post('/profile/submit', [InvestigatorController::class, 'store'])->name('profile.submit');
    Route::get('/investigator-profile', [InvestigatorController::class, 'profileView'])->name('view-profile');
    Route::get('/my-profile', [InvestigatorController::class, 'myProfile'])->name('my-profile');
    Route::get('/reset-password', [InvestigatorController::class, 'investigatorResetPassword'])
        ->name('reset-password');
    Route::post('/update-password', [InvestigatorController::class, 'investigatorPasswordUpdate'])
        ->name('update-password');
    Route::post('/my-profile/update', [InvestigatorController::class, 'investigatorProfileUpdate'])
        ->name('profile.update');
    Route::get('/company-admins', [CompanyAdminsController::class, 'index'])
        ->name('company-admins.index');
    Route::post('/company-admins/block-unblock/{company_admin_id}', [CompanyAdminsController::class, 'blockUnblockCompanyAdmin'])
        ->name('company-admins.block-unblock');
});
