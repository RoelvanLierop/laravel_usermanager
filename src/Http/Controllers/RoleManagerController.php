<?php
/**
 * Role Manager Controller
 */
namespace Roelvanlierop\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;
use Roelvanlierop\Usermanager\Models\Teams;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Role Manager Controller
 *
 * A Controller for controlling roles.
 *
 * @package Roelvanlierop\Usermanager\Http\Controllers
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Controller class
 */
class RoleManagerController extends Controller
{

    /**
     * Role (list) read method
     *
     * Read a role list or single role based on ID
     *
     * @param mixed $id Role ID
     * @return View User view with the current list or single role
     */
    public function read( $id = null ): View
    {
        $data = [];
        $data['requestid'] = $id;
        $data['roles'] = Role::all();
        $data['roleCount'] = $data['roles']->count();

        if( $id !== null && $data['roleCount'] > 0 )
        {
            $newRole = $data['roles']->find( $id );
            $data['roles'] = new Collection();
            if( $newRole !== null )
            {
                $data['roles'] = new Collection( [ $newRole ] );
                $data['roleCount'] = 1;
            }
            $data['teams'] = Teams::all();
        }

        return view('usermanager::roles.read', $data);
    }

    /**
     * Create Role method
     *
     * Method which shows the create role form, update is used to communicate with the database
     *
     * @param Request $request Request variable
     * @return View Returns role creation view
     */
    public function create( Request $request ): View
    {
        $data = [];

        return view('usermanager::roles.create', $data);
    }

    /**
     * Update role method
     *
     * Method used for creating and updating roles (CRUD Method)
     *
     * @param Request $request Request variable
     * @return RedirectResponse Returns the user to the last seen view
     */
    public function update( Request $request ): RedirectResponse
    {
        $role = ( $request->post('id') ? Role::find( $request->post('id') ):new Role() );
        $role->name = $request->post('name');
        $role->team_id = session('team_id');
        $role->save();

        return redirect()->back();
    }

    /**
     * Delete role Method
     *
     * Method for deleting roles from the database
     *
     * @param mixed $id Role ID
     * @return RedirectResponse Returns the user to the last seen view
     */
    public function delete( $id = null ): RedirectResponse
    {
        if( $id !== null )
        {
            Role::find( $id )->delete();
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        return redirect()->back();
    }
}
