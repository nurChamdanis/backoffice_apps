<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipControllers;
// Homepage Route
Route::group(['middleware' => ['web', 'checkblocked']], function () {
    Route::get('/terms', 'App\Http\Controllers\TermsController@terms')->name('terms');

});

	
// Authentication Routes
// Auth::routes();

// Public Routes
Route::group(['middleware' => ['web', 'activity', 'checkblocked']], function () {
    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'App\Http\Controllers\Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'App\Http\Controllers\Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'App\Http\Controllers\Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'App\Http\Controllers\Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'App\Http\Controllers\Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'App\Http\Controllers\Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'App\Http\Controllers\RestoreUserController@userReActivate']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth','activity', 'checkblocked']], function () {
    Route::get('/activation-required', ['uses' => 'App\Http\Controllers\Auth\ActivateController@activationRequired'])->name('activation-required');
});


Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    //manageuser
    
    
// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activity', 'twostep']], function () {
    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', [
        'as'   => 'public.home',
        'uses' => 'App\Http\Controllers\UserController@index',
        'name' => 'home',
    ]);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@show',
    ]);

    /**avatar update**/
        Route::get('avatar/{id}', [App\Http\Controllers\UsersManagementController::class, 'avatarupdate'])->name('pages.usersmanagement.avatarupdate');
        Route::get('update-avatar/{id}', [App\Http\Controllers\UsersManagementController::class, 'avatarstore'])->name('pages.usersmanagement.avatarupdate');

        /* routes for Users Controller */
    Route::get('users', 'UsersController@index')->name('users.index');
    Route::get('users/index/{filter?}/{filtervalue?}', 'UsersController@index')->name('users.index');   
    Route::get('users/view/{rec_id}', 'UsersController@view')->name('users.view');
    Route::get('users/masterdetail/{rec_id}', 'UsersController@masterDetail')->name('users.masterdetail')->withoutMiddleware(['rbac']); 

    Route::any('account/edit', 'AccountController@edit')->name('account.edit'); 
    Route::get('account', 'AccountController@index');   
    Route::post('account/changepassword', 'AccountController@changepassword')->name('account.changepassword');  
    Route::any('users/edit/{rec_id}', 'UsersController@edit')->name('users.edit');Route::any('users/editfield/{rec_id}', 'UsersController@editfield');  
    Route::get('users/delete/{rec_id}', 'UsersController@delete');
    
    /* routes for Membership Controller */
    Route::get('membership', [App\Http\Controllers\MembershipController::class, 'index'])->name('pages.membership.list');
    Route::get('create-member', [App\Http\Controllers\MembershipController::class, 'create'])->name('pages.membership.create-member');
    Route::post('simpan-member', [App\Http\Controllers\MembershipController::class, 'store'])->name('pages.membership.create-member');
    Route::get('edit-member/{id}', [App\Http\Controllers\MembershipController::class, 'edit'])->name('pages.membership.edit-member');
    Route::post('update-member/{id}', [App\Http\Controllers\MembershipController::class, 'update'])->name('pages.membership.update-member');
    Route::get('delete-member/{id}', [App\Http\Controllers\MembershipController::class, 'destroy'])->name('pages.membership.delete-member');

    Route::post('search-member', [App\Http\Controllers\MembershipController::class, 'search'])->name('search-member');
	
	
    /**DASHBOARD*/

Route::get('produkChart', [App\Http\Controllers\TransController::class, 'produkChart'])->name('produkChart');
Route::get('produkUser', [App\Http\Controllers\TransController::class, 'produkUser'])->name('produkUser');
Route::get('depositChart', [App\Http\Controllers\TransController::class, 'depositChart'])->name('depositChart');
Route::get('depositUser', [App\Http\Controllers\TransController::class, 'depositUser'])->name('depositUser');
Route::get('regChart', [App\Http\Controllers\TransController::class, 'regChart'])->name('regChart');
Route::get('harianChart', [App\Http\Controllers\TransController::class, 'harianChart'])->name('harianChart');
Route::get('transUser', [App\Http\Controllers\TransController::class, 'transUser'])->name('transUser');
Route::get('regUser', [App\Http\Controllers\TransController::class, 'regUser'])->name('regUser');
Route::get('showData', [App\Http\Controllers\TransController::class, 'showData']);
Route::get('produkData', [App\Http\Controllers\TransController::class, 'produkData']);
Route::get('userData', [App\Http\Controllers\TransController::class, 'userData']);
Route::get('salesChart', [App\Http\Controllers\TransController::class, 'salesChart']);
Route::get('pieChart', [App\Http\Controllers\TransController::class, 'pieChart'])->name('pieChart');


/**Permission***/
Route::get('/permissions-roles', [App\Http\Controllers\PermissionsRolesController::class, 'index']);
Route::get('/create-permission', [App\Http\Controllers\PermissionsRolesController::class, 'create']);
Route::post('simpan-permission', [App\Http\Controllers\PermissionsRolesController::class, 'store'])->name('pages.permissions_roles.create');
Route::get('/edit-permission/{permission_id}', [App\Http\Controllers\PermissionsRolesController::class, 'edit'])->name('permissions_roles.edit');
Route::post('/edit-permission/{permission_id}', [App\Http\Controllers\PermissionsRolesController::class, 'update']);
Route::get('/delete-permission/{id}', [App\Http\Controllers\PermissionsRolesController::class, 'destroy']);
/****Role***/
Route::get('/roles', [App\Http\Controllers\AdminRolesController::class, 'index'])->name('laravelroles::roles.index');

Route::get('/admin-roles', [App\Http\Controllers\AdminRolesController::class, 'index']);
Route::get('/create-roles', [App\Http\Controllers\AdminRolesController::class, 'create']);
Route::post('simpan-role', [App\Http\Controllers\AdminRolesController::class, 'store'])->name('pages.admin_roles.create');
Route::get('/edit-roles/{id}', [App\Http\Controllers\AdminRolesController::class, 'edit'])->name('admin_roles.edit');
Route::post('/edit-roles/{id}', [App\Http\Controllers\AdminRolesController::class, 'update']);
Route::get('/delete-roles/{id}', [App\Http\Controllers\AdminRolesController::class, 'destroy']);

/**Select***/
Route::get('/dropdown-permission', [App\Http\Controllers\DropdownController::class, 'permission']);
Route::get('/dropdown-role', [App\Http\Controllers\DropdownController::class, 'roles']);
/******/

});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'currentUser', 'activity', 'twostep', 'checkblocked']], function () {
    // User Profile and Account Routes
    Route::resource(
        'profile',
        \App\Http\Controllers\ProfilesController::class,
        [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => 'profile.updateUserAccount',
        'uses' => 'App\Http\Controllers\ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => 'profile.updateUserPassword',
        'uses' => 'App\Http\Controllers\ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => 'profile.deleteUserAccount',
        'uses' => 'App\Http\Controllers\ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => 'App\Http\Controllers\ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'App\Http\Controllers\ProfilesController@upload']);
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'role:admin', 'activity', 'twostep', 'checkblocked']], function () {
    Route::resource('/users/deleted', \App\Http\Controllers\SoftDeletesController::class, [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', \App\Http\Controllers\UsersManagementController::class, [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', 'App\Http\Controllers\UsersManagementController@search')->name('search-users');

    Route::resource('themes', \App\Http\Controllers\ThemesManagementController::class, [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'App\Http\Controllers\AdminDetailsController@listRoutes');
	
});

Route::redirect('/php', '/phpinfo', 301);
