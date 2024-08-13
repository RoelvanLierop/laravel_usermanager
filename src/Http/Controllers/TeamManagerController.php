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
     */
    public function read( $id = null )
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
                $data['teams'] = new Collection( [ $newteam->first() ] );
            }
        }
        return view('usermanager::teams.read', $data);
    }

    public function profile()
    {
        $data['teams'] = Teams::all();
        if( session('team_id') ) {
            $data['teams'] = new Collection( [ $data['teams']->find( session('team_id') )->first() ] );
        }
        return view('usermanager::teams.profile', $data);
    }

    public function create( Request $request )
    {
        $data = [];
        return view('usermanager::teams.create', $data);
    }

    public function update( Request $request )
    {
        $validator = $request->validate([
            'team_name' => 'required|unique:teams|max:255',
        ]);

        $team = ( $request->post('id') ? Teams::find( $request->post('id') ):new Teams() );
        $team->team_name = $request->post('team_name');
        $team->save();

        return redirect()->back()->withErrors($validator)->withInput();
    }

    public function delete( $id = null )
    {
        Teams::find( $id )->first()->delete();

        return redirect()->back();
    }
}
