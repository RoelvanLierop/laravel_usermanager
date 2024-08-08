<?php
/**
 * User Manager Controller
 */
namespace Roelvanlierop\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

/**
 * User Manager Controller
 *
 * A Controller for controlling users.
 *
 * @package Roelvanlierop\Usermanager\Http\Controllers
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Controller class
 */
class PermissionManagerController extends Controller
{
    /**
     */
    public function read( $id = null )
    {
        $data = [];
        $data['requestid'] = $id;
        $data['permissions'] = Permission::all();
        $data['permissionCount'] = $data['permissions']->count();
        if( $id !== null && $data['permissionCount'] > 0 )
        {
            $newPermission = $data['permissions']->find( $id );
            $data['permissions'] = new Collection();
            if( $newPermission !== null )
            {
                $data['permissions'] = new Collection( [ $newPermission->first() ] );
            }
        }
        return view('usermanager::permissions.read', $data);
    }

    public function create( Request $request )
    {
        $data = [];
        return view('usermanager::permissions.create', $data);
    }

    public function update( Request $request )
    {
        $permission = ( $request->post('id') ? Permission::find( $request->post('id') ):new Permission() );
        $permission->name = $request->post('name');
        $permission->save();

        return redirect()->back();
    }

    public function delete( $id = null )
    {

        Permission::find( $id )->first()->delete();

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->back();
    }
}
