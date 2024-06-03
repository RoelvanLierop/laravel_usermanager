<?php
/**
 * Prodiz Memoria User Switcher Controller
 */
namespace Prodizmemoria\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 * Prodiz Memoria User Switcher Controller
 *
 * A Controller for "user switching", aka shadow accounts.
 *
 * @package Prodizmemoria\Usermanager\Http\Controllers
 * @author Roel van Lierop | Prodiz Memoria Lead Developer - <roel@aandachttrekkers.nl>
 * @category Laravel Controller class
 */
class UserSwitcherController extends Controller
{
    /** @var string Configuration file prefix */
    const CONFIGPREFIX = 'usermanager';

    /**
     * Method for starting a shadow login session
     *
     * Gets a new user to login from the route, and puts the old user id in a session variable called shadow_user
     *
     * @param $id String New ID to login
     * @return RedirectResponse Redirect response from Laravel
     */
    public function start( $id )
    {
        $new_user = User::find( $id );
        if( !Session::has( 'shadow_user' ) ) {
            Session::put('shadow_user', Auth::id());
        }
        Auth::login( $new_user );
        if( config(self::CONFIGPREFIX . '.routes.shadowlogin_return_uri') ) {
            return Redirect::intended(App::currentLocale() . config(self::CONFIGPREFIX . '.routes.shadowlogin_return_uri') );
        } else {
            return Redirect::back();
        }
    }

    /**
     * Method for stopping a shadow login session
     *
     * Retrieves the shadow_user session variable and uses that id to login the old user
     *
     * @return RedirectResponse Redirect response from Laravel
     */
    public function stop()
    {
        $id = Session::get( 'shadow_user' );
        $orig_user = User::find( $id );
        Auth::login( $orig_user );
        Session::forget( 'shadow_user' );
        return Redirect::back();
    }

    /**
     * Method that formats the string that is displayed when a shadow user session is active
     *
     * @return String String with message and link that resets the shadow user session
     */
    public static function switchUserLink(): String {
        $new_id = Auth::id();
        $new_user = User::find( $new_id );

        $old_id = Session::get( 'shadow_user' );
        $old_user = User::find( $old_id );

        $languageNamespace = ( config(self::CONFIGPREFIX . '.prefixes.languagenamespace') !== '' ? config(self::CONFIGPREFIX . '.prefixes.languagenamespace') . '::' : '') . config(self::CONFIGPREFIX . '.prefixes.languagefile');
        $oldUserLink = '<a href="' . route( 'userswitcher_stop_' . app()->getLocale(), ['locale' => app()->getLocale()]) . '">' . $old_user->name . '</a>';

        return ucfirst(__( $languageNamespace . '.page_sections.shadowbar_prefix', ['oldname' => $oldUserLink, 'newname' => $new_user->name]));
    }
}

