<?php
/**
 * User Manager Controller
 */
namespace Roelvanlierop\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

/**
 * User Manager Controller
 *
 * A Controller for controlling users.
 *
 * @package Roelvanlierop\Usermanager\Http\Controllers
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Controller class
 */
class RoleManagerController extends Controller
{
    /**
     */
    public function read( $id = null )
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
                $data['roles'] = new Collection( [ $newRole->first() ] );
            }
        }
        return view('usermanager::roles.read', $data);
    }

    public function create( Request $request )
    {
        $data = [];
        return view('usermanager::roles.create', $data);
    }

    public function update( Request $request )
    {
        $role = ( $request->post('id') ? Role::find( $request->post('id') ):new Role() );
        $role->name = $request->post('name');
        $role->save();

        return redirect()->back();
    }

    public function delete( $id = null )
    {

        Role::find( $id )->first()->delete();

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->back();
    }
}
