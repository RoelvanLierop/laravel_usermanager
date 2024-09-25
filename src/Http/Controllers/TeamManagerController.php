<?php
/**
 * Team Manager Controller
 */
namespace Roelvanlierop\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Roelvanlierop\Usermanager\Models\Teams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
            $data['roles'] = DB::table('roles')->where('team_id', '=', $data['teams'][0]->id )->pluck('name')->all();
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
    public function profile(): View
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
}
