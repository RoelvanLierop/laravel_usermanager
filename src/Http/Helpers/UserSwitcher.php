<?php
/**
 * Relogin helper
 */
namespace Roelvanlierop\Usermanager\Http\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * User Switcher Trait
 *
 * This trait helps with relogin actions. You can login as a different user while the current user ID stays in memory.
 *
 * @package Roelvanlierop\Usermanager\Http\Helpers
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Trait
 */
trait UserSwitcher
{
    /**
     * Method that formats the string that is displayed when a shadow user session is active
     *
     * @return String String with message and link that resets the shadow user session
     */
    public static function link(): String {
        $new_id = Auth::id();
        $new_user = User::find( $new_id );
        $old_id = Session::get( 'relogin_user' );
        $old_user = User::find( $old_id );
        $oldUserLink = ( $old_user!== null ? '<a href="' . route( 'relogin_stop') . '">' . $old_user->name . '</a>':'' );

        return $oldUserLink;
    }
}
