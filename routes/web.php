<?php

use App\Http\Controllers\Admin\HmController as AdminHmController;
use App\Http\Controllers\CompanyAdmin\AssignmentsController;
use App\Http\Controllers\CompanyAdmin\CompanyUsersController;
use App\Http\Controllers\CompanyAdmin\InternalInvestigatorsController;
use App\Http\Controllers\CompanyAdmin\NotificationController;
use App\Http\Controllers\CompanyAdmin\SettingsController;
use App\Http\Controllers\Hm\AssignmentsController as HMAssignmentsController;
use App\Http\Controllers\Hm\InvestigatorController as HMInvestigatorController;
use App\Http\Controllers\Hm\HmController;
use App\Http\Controllers\Hm\HmSettingsController;
use App\Http\Controllers\Hm\NotificationController as HmNotificationController;
use App\Http\Controllers\Investigator\CompanyAdminsController;
use App\Http\Controllers\Investigator\InvitationsController;
use App\Http\Controllers\Investigator\NotificationsController;
use App\Http\Controllers\Investigator\InvestigatorSettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyAdminController as AdminCompanyController;
use App\Http\Controllers\Admin\InvestigatorController as AdminInvestigatorController;
use App\Http\Controllers\CompanyAdmin\CompanyAdminController;
use App\Http\Controllers\CompanyAdmin\InvestigatorController as CAInvestigatorController;
use App\Http\Controllers\Investigator\InvestigatorController;
use App\Http\Controllers\TwilioController;

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

Route::get('/privacy-policy', function () {
    $title = 'ILOGISTIC Portal | Privacy Policy';
    return view('privacy-policy', compact('title'));
});

Route::get('/terms-and-conditions', function () {
    $title = 'ILOGISTIC Portal | Terms & Conditions';
    return view('terms-and-conditions', compact('title'));
});

Auth::routes();


Route::get('/send-sms', [TwilioController::class, 'sendSms']);

// Admin Dashboard Routes
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

// Company Admin Dashboard Routes
Route::group(['prefix' => 'company-admin', 'as' => 'company-admin.', 'middleware' => ['company-admin']], function () {

    Route::get('/', [CompanyAdminController::class, 'index'])->name('index');
    Route::get('/profile', [CompanyAdminController::class, 'viewProfile'])->name('profile');
    Route::get('/find-investigators', [CompanyAdminController::class, 'findInvestigator'])->name('find_investigator');

    Route::post('/find-investigators-histories', [CompanyAdminController::class, 'saveInvestigatorSearchHistory'])->name('save-investigator-search-history');

    Route::post('/assignment/save-notes', [AssignmentsController::class, 'saveAssignmentNotes'])->name('assignment.save-notes');
    Route::get('/assignment/get-notes', [AssignmentsController::class, 'getAssignmentNotes'])->name('assignment.get-notes');

    Route::post('/find-investigators-histories', [CompanyAdminController::class, 'saveInvestigatorSearchHistory'])->name('save-investigator-search-history');

    Route::post('/search-investigators-histories', [CompanyAdminController::class, 'updateInvestigatorSearchHistory'])->name('update-investigator-search-history');

    Route::get('/assignments', [AssignmentsController::class, 'index'])->name('assignments');
    Route::get('/assignments/create', [AssignmentsController::class, 'create'])->name('assignments.create');
    Route::post('/assignments/invite', [AssignmentsController::class, 'invite'])->name('assignments.invite');
    Route::post('/assignments/store', [AssignmentsController::class, 'store'])->name('assignments.store');

    Route::get('/assignment/{assignment}/show', [AssignmentsController::class, 'show'])->name('assignment.show');
    Route::get('/assignment/{assignment}/investigator/{user}/', [AssignmentsController::class, 'getInvestigator'])->name('assignment.show-investigator');

    Route::get('/assignments/{assignment}/edit', [AssignmentsController::class, 'edit'])->name('assignments.edit');
    Route::get('/assignments/{assignment}/mark-as-complete', [AssignmentsController::class, 'markComplete'])->name('assignments.mark-as-complete');

    Route::put('/assignments/{assignment}/update', [AssignmentsController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}/destroy', [AssignmentsController::class, 'destroy'])->name('assignments.destroy');

    Route::post('/assignments/{assignment}/delete', [AssignmentsController::class, 'softDeleteAssignment'])->name('assignments.delete');

    Route::get('/select2-assignments', [AssignmentsController::class, 'select2Assignments'])->name('select2-assignments');
    Route::post('/profile/submit', [CompanyAdminController::class, 'store'])->name('profile.submit');
    Route::get('/my-profile', [CompanyAdminController::class, 'myProfile'])->name('my-profile');
    Route::get('/reset-password', [CompanyAdminController::class, 'companyResetPassword'])
        ->name('reset-password');
    Route::post('/update-password', [CompanyAdminController::class, 'companyPasswordUpdate'])
        ->name('update-password');
    Route::post('/my-profile/update', [CompanyAdminController::class, 'companyProfileUpdate'])
        ->name('profile.update');
    Route::get('/view-profile', [CompanyAdminController::class, 'companyProfile'])->name('view');

    Route::get('/assignments-list', [AssignmentsController::class, 'assignments_list'])->name('assignments-list');

    Route::get('/assignment/fetchAssignmentUser', [AssignmentsController::class, 'getAssignmentUser'])->name('assignment.assignment-user.show');
    Route::post('/assignment/hire-now', [AssignmentsController::class, 'hireInvestigator'])->name('assignment.hire-now');

    /** Recall Assignment */

    Route::get('/assignment/{id}/{user_id}/recall', [AssignmentsController::class, 'assignmentRecall'])->name('assignment.recall');

    // send msg from assignment
    Route::post('/assignment/send-user-msg', [AssignmentsController::class, 'sendMessage'])->name('assignment.send-msg');
    Route::post('/assignment/send-attachment', [AssignmentsController::class, 'sendAttachmentMessage'])->name('assignment.send-attachment');

    /** Settings**/
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/store', [SettingsController::class, 'store'])->name('settings.store');

    Route::get('/notification/latestNotification', [NotificationController::class, 'latestNotification'])->name('notification.latestNotification');
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/notification/{notification}/show', [NotificationController::class, 'show'])->name('notification.show');
    Route::get('/notification/{notification}/destroy', [NotificationController::class, 'destroy'])->name('notification.destroy');
    Route::get('/notification/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notification.mark-all-read');


    Route::group(['prefix' => 'company-users', 'as' => 'company-users.'], function () {
        Route::get('/', [CompanyUsersController::class, 'index'])->name('index');
        Route::get('/add', [CompanyUsersController::class, 'view'])->name('add');
        Route::post('/submit', [CompanyUsersController::class, 'store'])->name('submit');
        Route::post('/update', [CompanyUsersController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CompanyUsersController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [CompanyUsersController::class, 'edit'])->name('edit');
        Route::get('/reset-password/{id}', [CompanyUsersController::class, 'resetPassword'])
            ->name('reset-password');
        Route::post('/update-password', [CompanyUsersController::class, 'passwordUpdate'])
            ->name('update-password');
    });

    Route::group(['prefix' => 'internal-investigators', 'as' => 'internal-investigators.'], function () {
        Route::get('/', [InternalInvestigatorsController::class, 'index'])->name('index');

        Route::get('/add', [InternalInvestigatorsController::class, 'add'])->name('add');
        Route::post('/submit', [InternalInvestigatorsController::class, 'store'])->name('submit');
        Route::get('/delete/{id}', [InternalInvestigatorsController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [InternalInvestigatorsController::class, 'edit'])->name('edit');
        Route::get('/reset-password/{id}', [InternalInvestigatorsController::class, 'resetPassword'])
            ->name('reset-password');
        Route::post('/update-password', [InternalInvestigatorsController::class, 'passwordUpdate'])
            ->name('update-password');
    });


    Route::group(['prefix' => 'investigators', 'as' => 'investigators.'], function () {
        Route::get('/{id}/view', [CAInvestigatorController::class, 'profileView'])->name('view');
    });


});

// HM Dashboard Routes
Route::group(['prefix' => 'hm', 'as' => 'hm.', 'middleware' => ['hm']], function () {
    Route::get('/', [HmController::class, 'index'])->name('index');
    Route::get('/company-users', [HmController::class, 'companyUsers'])->name('company-users.index');
    Route::get('/profile', [HmController::class, 'viewProfile'])->name('profile');
    Route::get('/find-investigators', [CompanyAdminController::class, 'findInvestigator'])->name('find_investigator');
    Route::post('/find-investigators-histories', [CompanyAdminController::class, 'saveInvestigatorSearchHistory'])->name('save-investigator-search-history');

    Route::post('/search-investigators-histories', [CompanyAdminController::class, 'updateInvestigatorSearchHistory'])->name('update-investigator-search-history');

    Route::get('/assignments-list', [HMAssignmentsController::class, 'assignments_list'])->name('assignments-list');
    Route::get('/assignments', [HMAssignmentsController::class, 'index'])->name('assignments');

    Route::get('/assignments/create', [HMAssignmentsController::class, 'create'])->name('assignments.create');
    Route::post('/assignments/invite', [HMAssignmentsController::class, 'invite'])->name('assignments.invite');
    Route::post('/assignments/store', [HMAssignmentsController::class, 'store'])->name('assignments.store');

    Route::get('/assignment/{assignment}/show', [HMAssignmentsController::class, 'show'])->name('assignment.show');

    Route::get('/assignment/fetchAssignmentUser', [HMAssignmentsController::class, 'getAssignmentUser'])->name('assignment.assignment-user.show');
    Route::post('/assignment/hire-now', [HMAssignmentsController::class, 'hireInvestigator'])->name('assignment.hire-now');

    Route::get('/assignments/{assignment}/edit', [HMAssignmentsController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{assignment}/update', [HMAssignmentsController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}/destroy', [HMAssignmentsController::class, 'destroy'])->name('assignments.destroy');
    Route::get('/select2-assignments', [HMAssignmentsController::class, 'select2Assignments'])->name('select2-assignments');
    Route::post('/profile/submit', [HmController::class, 'store'])->name('profile.submit');
    Route::get('/my-profile', [HmController::class, 'myProfile'])->name('my-profile');
    Route::get('/reset-password', [HmController::class, 'hmResetPassword'])
        ->name('reset-password');
    Route::post('/update-password', [HmController::class, 'hmPasswordUpdate'])
        ->name('update-password');
    Route::post('/my-profile/update', [HmController::class, 'hmProfileUpdate'])
        ->name('profile.update');
    Route::get('/view-profile', [HmController::class, 'companyProfile'])->name('view');
    /** Settings**/
    Route::get('/settings', [HmSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/store', [HmSettingsController::class, 'store'])->name('settings.store');
    // send msg from assignment
    Route::post('/assignment/send-user-msg', [HMAssignmentsController::class, 'sendMessage'])->name('assignment.send-msg');
    Route::post('/assignment/send-attachment', [HMAssignmentsController::class, 'sendAttachmentMessage'])->name('assignment.send-attachment');

    Route::get('/notification/latestNotification', [HmNotificationController::class, 'latestNotification'])->name('notification.latestNotification');
    Route::get('/notification', [HmNotificationController::class, 'index'])->name('notification.index');
    Route::get('/notification/{notification}/show', [HmNotificationController::class, 'show'])->name('notification.show');
    Route::get('/notification/{notification}/destroy', [HmNotificationController::class, 'destroy'])->name('notification.destroy');
    Route::get('/notification/mark-all-read', [HmNotificationController::class, 'markAllRead'])->name('notification.mark-all-read');
    Route::group(['prefix' => 'internal-investigators', 'as' => 'internal-investigators.'], function () {
        Route::get('/', [InternalInvestigatorsController::class, 'index'])->name('index');
    });
    Route::group(['prefix' => 'investigators', 'as' => 'investigators.'], function () {
        Route::get('/{id}/view', [HMInvestigatorController::class, 'profileView'])->name('view');
    });
});


// Investigator Dashboard Routes
Route::group(['prefix' => 'investigator', 'as' => 'investigator.', 'middleware' => ['investigator']], function () {
    Route::get('/', [InvestigatorController::class, 'index'])->name('index');
    Route::get('/profile', [InvestigatorController::class, 'viewProfile'])->name('profile');
    Route::get('/view', [InvestigatorController::class, 'view'])->name('view');
    Route::post('/profile/submit', [InvestigatorController::class, 'store'])->name('profile.submit');
    Route::get('/investigator-profile', [InvestigatorController::class, 'profileView'])->name('view-profile');
    Route::get('/my-profile', [InvestigatorController::class, 'myProfile'])->name('my-profile');
    Route::post('/sync-calendar', [InvestigatorController::class, 'investigatorSyncCalendar'])->name('sync-calendar'); // CALENDAR SYNC ROUTE

    Route::get('/checkToken', [InvestigatorController::class, 'checkTokenExpiry'])->name('checkToken');
    Route::delete('/disconnect-calendar', [InvestigatorController::class, 'disconnectCalendar'])->name('disconnect-calendar');

    Route::delete('/remove-events', [InvestigatorController::class, 'removeEvents'])->name('remove-events');

    Route::get('/sync-calendar/google-oauth2callback', [InvestigatorController::class, 'googleOauth2Callback'])->name('sync-calendar/google-oauth2callback'); // GOOGLE AUTH ROUTE

    Route::get('/calendar', [InvestigatorController::class, 'investigatorCalendar'])->name('calendar');

    Route::post('/calendar/fetch-events', [InvestigatorController::class, 'investigatorCalendarEvents'])->name('calendar.fetch-events');
    Route::get('/calendar/fetch-events-onload', [InvestigatorController::class, 'investigatorCalendarEventsOnLoad'])->name('calendar.fetch-events-onload');

    Route::get('/reset-password', [InvestigatorController::class, 'investigatorResetPassword'])->name('reset-password');
    Route::post('/update-password', [InvestigatorController::class, 'investigatorPasswordUpdate'])->name('update-password');
    Route::post('/my-profile/update', [InvestigatorController::class, 'investigatorProfileUpdate'])->name('profile.update');
    Route::get('/company-admins', [CompanyAdminsController::class, 'index'])->name('company-admins.index');
    Route::post('/company-admins/block-unblock/{company_admin_id}', [CompanyAdminsController::class, 'blockUnblockCompanyAdmin'])->name('company-admins.block-unblock');

    // send msg from assignment
    Route::post('/assignment/send-msg', [InvitationsController::class, 'sendMessage'])->name('assignment.send-msg');
    Route::post('/assignment/send-attachment', [InvitationsController::class, 'sendAttachmentMessage'])->name('assignment.send-attachment');

    // confirm assignment status
    Route::get('/assignment/{id}/confirmation/{status}', [InvitationsController::class, 'assignmentConfirmation'])->name('assignment.confirmation');

    // Invitation routes
    Route::get('/invitations', [InvitationsController::class, 'index'])->name('invitations.index');
    Route::get('/assignments-listing', [InvitationsController::class, 'index'])->name('assignments-listing');
    Route::get('/assignment/{assignment_user}/show', [InvitationsController::class, 'show'])->name('assignment.show');
    Route::get('/assignment/{assignment_user}/destroy', [InvitationsController::class, 'destroy'])->name('assignment.destroy');
    /** Settings**/
    Route::get('/settings', [InvestigatorSettingsController::class, 'index'])->name('index');
    Route::post('/settings/store', [InvestigatorSettingsController::class, 'store'])->name('settings.store');

    // Notification routes
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}/show', [NotificationsController::class, 'show'])->name('notifications.show');
    Route::get('/notifications/{notification}/destroy', [NotificationsController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/latestNotification', [NotificationsController::class, 'latestNotification'])->name('notifications.latestNotification');
});
