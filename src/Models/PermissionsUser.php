<?php
/**
 * Permissions User Model
 */
namespace Roelvanlierop\Usermanager\Models;

use App\Models\User;
use Roelvanlierop\Usermanager\Models\Teams;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Permissions User Model
 *
 * A extended User model that incorporates finding Teams
 *
 * @package Roelvanlierop\Usermanager\Models
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Model class
 */
class PermissionsUser extends User {

    /**
     * Team list finder
     *
     * Find teams associated with the current user
     *
     * @var User|null $user User to question, if null then the current user is used
     * @return array Array with teams corresponding with the current user
     */
    public static function teams( $user = null ): array
    {
        if( $user === null )
        {
            $user = Auth::user();
        }

        $memberships = DB::table('model_has_roles')->select('team_id')
        ->where( 'model_type', '=', 'App\Models\User' )
        ->where( 'model_id', '=', $user->id )
        ->distinct()->get()->toArray();

        $out = [];

        foreach( $memberships as $i => $mo )
        {
            $teamsFound = Teams::find( $mo->team_id );
            if( $teamsFound !== null ) {
                $out[] = $teamsFound->first();
            }
        }

        return $out;
    }

     /**
     * Active team finder
     *
     * Find the currently selected team for a user
     *
     * @var User|null $user User to question, if null then the current user is used
     * @return array Return the currently active team
     */
    public static function activeTeam( $user = null ): array
    {
        if( session('team_id') )
        {
            return Teams::find( session('team_id') )->first()->toArray();
        }

        return  ['team_name' => ''];
    }
}
