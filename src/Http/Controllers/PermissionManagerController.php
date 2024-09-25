<?php
/**
 * Permission Manager Controller
 */
namespace Roelvanlierop\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Permission Manager Controller
 *
 * A Controller for controlling permissions.
 *
 * @package Roelvanlierop\Usermanager\Http\Controllers
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Controller class
 */
class PermissionManagerController extends Controller
{

    /**
     * Permission (list) read method
     *
     * Read a permission list or single permission based on ID
     *
     * @param mixed $id Permission ID
     * @return View User view with the current list or single permission
     */
    public function read( $id = null ): View
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

    /**
     * Create Permission method
     *
     * Method which shows the create permission form, update is used to communicate with the database
     *
     * @param Request $request Request variable
     * @return View Returns permission creation view
     */
    public function create( Request $request ): View
    {
        $data = [];

        return view('usermanager::permissions.create', $data);
    }

    /**
     * Update permission method
     *
     * Method used for creating and updating permissions (CRUD Method)
     *
     * @param Request $request Request variable
     * @return RedirectResponse Returns the user to the last seen view
     */
    public function update( Request $request ): RedirectResponse
    {
        $permission = ( $request->post('id') ? Permission::find( $request->post('id') ):new Permission() );
        $permission->name = $request->post('name');
        $permission->save();

        return redirect()->back();
    }

    /**
     * Delete permission Method
     *
     * Method for deleting permissions from the database
     *
     * @param mixed $id Permission ID
     * @return RedirectResponse Returns the user to the last seen view
     */
    public function delete( $id = null ): RedirectResponse
    {
        Permission::find( $id )->first()->delete();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->back();
    }
}
