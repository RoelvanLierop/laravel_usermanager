<?php
/**
 * User Manager WEB Route
 *
 * @author Roel van Lierop - <roel.van.lierop@gmail.com>
 * @category Laravel Route File
 * @link ../vendor/roelvanlierop/usermanager/src/routes/web.php
 */

use Roelvanlierop\Usermanager\Http\Controllers\UserSwitcherController;
use Roelvanlierop\Usermanager\Http\Controllers\TeamManagerController;
use Roelvanlierop\Usermanager\Http\Controllers\UserManagerController;
use Roelvanlierop\Usermanager\Http\Controllers\RoleManagerController;
use Roelvanlierop\Usermanager\Http\Controllers\PermissionManagerController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web']
], function () {
    Route::get( '/teams/invite/{key?}', [TeamManagerController::class, 'acceptInvite'] )->name('team_acceptinvite');
});

Route::group([
    'middleware' => ['web', 'auth', 'teams']
], function () {
    /* User switcher */
    Route::get( '/relogin/start/{id}', [UserSwitcherController::class, 'start'] )->name('relogin_start');
    Route::get( '/relogin/stop', [UserSwitcherController::class, 'stop'] )->name('relogin_stop');

    /* Team Profile */
    Route::get( '/profile/team', [TeamManagerController::class, 'profile'] )->name('team_profile');

    /* Team manager */
    Route::get( '/teams/delete/{id?}', [TeamManagerController::class, 'delete'] )->name('team_delete');
    Route::get( '/teams/create', [TeamManagerController::class, 'create'] )->name('team_create');
    Route::get( '/teams/{id?}', [TeamManagerController::class, 'read'] )->name('team_read');
    Route::get( '/teams/switch/{id?}', [TeamManagerController::class, 'switch'] )->name('team_switch');
    Route::post( '/teams/create', [TeamManagerController::class, 'update'] )->name('team_create_post');
    Route::post( '/teams/invite', [TeamManagerController::class, 'invite'] )->name('team_invite');
    Route::patch( '/teams', [TeamManagerController::class, 'update'] )->name('team_update');

    /* User manager */
    Route::get( '/users/delete/{id?}', [UserManagerController::class, 'delete'] )->name('user_delete');
    Route::get( '/users/create', [UserManagerController::class, 'create'] )->name('user_create');
    Route::get( '/users/{id?}', [UserManagerController::class, 'read'] )->name('user_read');
    Route::post( '/users/create', [UserManagerController::class, 'update'] )->name('user_create_post');
    Route::patch( '/users', [UserManagerController::class, 'update'] )->name('user_update');

    /* Role manager */
    Route::get( '/roles/delete/{id?}', [RoleManagerController::class, 'delete'] )->name('role_delete');
    Route::get( '/roles/create', [RoleManagerController::class, 'create'] )->name('role_create');
    Route::get( '/roles/{id?}', [RoleManagerController::class, 'read'] )->name('role_read');
    Route::post( '/roles/create', [RoleManagerController::class, 'update'] )->name('role_create_post');
    Route::get( '/roles/assign/{id?}', [RoleManagerController::class, 'assignToTeam'] )->name('team_assign');
    Route::patch( '/roles', [RoleManagerController::class, 'update'] )->name('role_update');

    /* Permission manager */
    Route::get( '/permissions/delete/{id?}', [PermissionManagerController::class, 'delete'] )->name('permission_delete');
    Route::get( '/permissions/create', [PermissionManagerController::class, 'create'] )->name('permission_create');
    Route::get( '/permissions/{id?}', [PermissionManagerController::class, 'read'] )->name('permission_read');
    Route::post( '/permissions/create', [PermissionManagerController::class, 'update'] )->name('permission_create_post');
    Route::patch( '/permissions', [PermissionManagerController::class, 'update'] )->name('permission_update');
});
