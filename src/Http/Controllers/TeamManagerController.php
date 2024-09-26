<?php
/**
 * Team Manager Controller
 */
namespace Roelvanlierop\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Roelvanlierop\Usermanager\Mail\InviteUser;
use Roelvanlierop\Usermanager\Models\Teams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Roelvanlierop\Usermanager\Models\PermissionsUser;
use Roelvanlierop\Usermanager\Models\teamsInvites;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

/**
 * Team Manager Controller
 *
 * A Controller for controlling teams.
 *
 * @package Roelvanlierop\Usermanager\Http\Controllers
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Controller class
 */
class TeamManagerController extends Controller
{

    /**
     * Team (list) read method
     *
     * Read a team list or single team based on ID
     *
     * @param mixed $id Team ID
     * @return View User view with the current list or single team
     */
    public function read( $id = null ): View
    {
        $data = [];
        $data['requestid'] = $id;
        $data['teams'] = Teams::all();
        $data['teamCount'] = $data['teams']->count();

        if( $id !== null && $data['teamCount'] > 0 )
        {
            $newteam = $data['teams']->find( $id );
            $data['teams'] = new Collection();
            if( $newteam !== null )
            {
                $data['teams'] = new Collection( [ $newteam ] );
            }
            $data['teamCount'] = 1;
            $data['users'] = $data['teams'][0]->hasUsers();
            $data['roles'] = DB::table('roles')->where('team_id', '=', $data['teams'][0]->id )->pluck('name', 'id')->all();
        }

        return view('usermanager::teams.read', $data);
    }

    /**
     * Profile method
     *
     * Returns a team profile page to the user
     *
     * @return View View for a single (read-only) Team
     */
    public function profile( Request $request ): View
    {
        $data['teams'] = Teams::all();

        if( session('team_id') )
        {
            $data['teams'] = new Collection( [ $data['teams']->find( session('team_id') )->first() ] );
        }

        return view('usermanager::teams.profile', $data);
    }

    /**
     * Create Team method
     *
     * Method which shows the create team form, update is used to communicate with the database
     *
     * @param Request $request Request variable
     * @return View Returns team creation view
     */
    public function create( Request $request ): View
    {
        $data = [];

        return view('usermanager::teams.create', $data);
    }

    /**
     * Update team method
     *
     * Method used for creating and updating teams (CRUD Method)
     *
     * @param Request $request Request variable
     * @return RedirectResponse Returns the user to the last seen view
     */
    public function update( Request $request ): RedirectResponse
    {
        $validator = $request->validate([
            'team_name' => 'required|unique:teams|max:255',
        ]);

        $team = ( $request->post('id') ? Teams::find( $request->post('id') ):new Teams() );
        $team->team_name = $request->post('team_name');
        $team->save();

        return redirect()->back()->withErrors($validator)->withInput();
    }

    /**
     * Delete team Method
     *
     * Method for deleting team from the database
     *
     * @param mixed $id Team ID
     * @return RedirectResponse Returns the user to the last seen view
     */
    public function delete( $id = null ): RedirectResponse
    {
        Teams::find( $id )->first()->delete();

        /** @todo also remove permissions and roles when a team is removed */

        return redirect()->back();
    }

    /**
     * Switch team method
     *
     * Method for switching the active team, this requires the permissions and roles to be updated too.
     *
     * @param  mixed $id New Team ID to use
     * @return RedirectResponse Returns the user to the last seen view
     */
    public function switch( $id = null ): RedirectResponse
    {
        setPermissionsTeamId( $id );
        session( ['team_id' => $id ] );
        Auth::user()->unsetRelation('roles')->unsetRelation('permissions');

        return redirect()->back();
    }

    /**
     * Invite user method
     *
     * Method which invites a new or existing user to a team, with a specific role
     *
     * @param Request $request Request variable
     */
    public function invite( Request $request ): RedirectResponse
    {
        $invite = new TeamsInvites();
        $invite->team_id = $request->post('id');
        $invite->role_id = $request->post('role');
        $invite->invite_email = $request->post('email');
        $invite->invite_date = Carbon::today()->format('Y-m-d H:i:s');
        $invite->invite_key = md5( Carbon::today()->format('Y-m-d H:i:s') );

        $user = User::where('email', '=', $request->post('email'))->first();
        $pm = new PermissionsUser();

        $team = Teams::find( $invite->team_id );

        if( $user !== null && $pm::isActiveInTeam( $invite->team_id, $invite->user_id ) === false )
        {
            $invite->user_id = $user->id;
        }

        $invite->save();
        Mail::to( $request->post('email') )->send( new InviteUser( $invite, $team ) );

        return redirect()->back();
    }

    public function acceptInvite( Request $request )
    {
        // $request->key
        Auth::logout();

        $invite = TeamsInvites::where( 'invite_key', '=', $request->key )->first();
        if( $invite === null )
        {
            // No known invite
            var_dump('Unknown invitation');
            die();
        }
        elseif( $invite !== null && $invite->user_id !== null )
        {
            $role = Role::find( $invite->role_id );
            $user = User::find( $invite->user_id );
            Auth::login($user);
            DB::table('model_has_roles')->insert(
                [
                    'role_id' => $role->id,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                    'team_id' => $invite->team_id,
                ]
            );
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

            return redirect()->route( 'dashboard' );
        }
        elseif( $invite !== null && $invite->user_id === null )
        {
            // Known invite but unknown user, send this one to the register page!
            Auth::logout();
            return redirect()->route( 'register' )->with( [ 'invite' => $invite ] );
        }
    }
}
