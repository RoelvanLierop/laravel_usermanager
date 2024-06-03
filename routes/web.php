<?php
/**
 * User Manager WEB Route
 *
 * @author Roel van Lierop - <roel.van.lierop@gmail.com>
 * @category Laravel Route File
 * @link ../vendor/roelvanlierop/usermanager/src/routes/web.php
 */

use Roelvanlierop\Usermanager\Http\Controllers\UserSwitcherController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => ['web', 'auth']
], function () {
    /* User switcher */
    Route::get( '/relogin/start/{id}', [UserSwitcherController::class, 'start'] )->name('relogin_start');
    Route::get( '/relogin/stop', [UserSwitcherController::class, 'stop'] )->name('relogin_stop');
});
