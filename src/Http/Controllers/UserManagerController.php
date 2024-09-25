<?php
/**
 * User Manager Controller
 */
namespace Roelvanlierop\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * User Manager Controller
 *
 * A Controller for controlling users.
 *
 * @package Roelvanlierop\Usermanager\Http\Controllers
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Controller class
 */
class UserManagerController extends Controller
{
    /**
     * User (list) read method
     *
     * Read a user list or single user based on ID
     *
     * @param mixed $id User ID
     * @return View User view with the current list or single user
     */
    public function read( $id = null ): View
    {
        $data = [];
        $data['requestid'] = $id;
        $data['users'] = User::all();
        $data['userCount'] = $data['users']->count();

        if( $id !== null && $data['userCount'] > 0 )
        {
            $newUser = $data['users']->find( $id );
            $data['users'] = new Collection();
            if( $newUser !== null )
            {
                $data['users'] = new Collection( [ $newUser->first() ] );
            }
        }

        return view('usermanager::users.read', $data);
    }

    /**
     * Create User method
     *
     * Method which shows the create user form, update is used to communicate with the database
     *
     * @param Request $request Request variable
     * @return View Returns user creation view
     */
    public function create( Request $request ): View
    {
        $data = [];

        return view('usermanager::users.create', $data);
    }

    /**
     * Update user method
     *
     * Method used for creating and updating users (CRUD Method)
     *
     * @param Request $request Request variable
     * @return RedirectResponse Returns the user to the last seen view
     */
    public function update( Request $request ): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->withErrors($validator)->withInput();
    }

    /**
     * Delete user Method
     *
     * Method for deleting user from the database
     *
     * @param mixed $id User ID
     * @return RedirectResponse Returns the user to the last seen view
     */
    public function delete( $id = null ): RedirectResponse
    {
        User::find( $id )->first()->delete();

        /** @todo Also delete roles and permissions for current user */

        return redirect()->back();
    }
}
