<?php
/**
 * User Switcher Controller
 */
namespace Roelvanlierop\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 * User Switcher Controller
 *
 * A Controller for "user switching", while the original user is stored in a session.
 *
 * @package Roelvanlierop\Usermanager\Http\Controllers
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Controller class
 */
class UserSwitcherController extends Controller
{
    /**
     * Method for starting a relogin session
     *
     * Gets a new user to login from the route, and puts the old user id in a session variable called shadow_user
     *
     * @param $id String New ID to login
     * @return RedirectResponse Redirect response from Laravel
     */
    public function start( $id ): RedirectResponse
    {
        $new_user = User::find( $id );

        if( !Session::has( 'relogin_user' ) )
        {
            Session::put('relogin_user', Auth::id());
        }

        Auth::login( $new_user );

        if( config('usermanager.routes.relogin_return_uri') )
        {
            return Redirect::intended(App::currentLocale() . config('usermanager.routes.relogin_return_uri') );
        } else {
            return Redirect::back();
        }
    }

    /**
     * Method for stopping a relogin session
     *
     * Retrieves the shadow_user session variable and uses that id to login the old user
     *
     * @return RedirectResponse Redirect response from Laravel
     */
    public function stop(): RedirectResponse
    {
        $id = Session::get( 'relogin_user' );
        $orig_user = User::find( $id );

        Auth::login( $orig_user );
        Session::forget( 'relogin_user' );

        return Redirect::back();
    }
}

