<?php
/**
 * User Manager Controller
 */
namespace Roelvanlierop\Usermanager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

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
     */
    public function read( $id = null )
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

    public function create( Request $request )
    {
        $data = [];
        return view('usermanager::users.create', $data);
    }

    public function update( Request $request )
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->withErrors($validator)->withInput();
    }

    public function delete( $id = null )
    {
        User::find( $id )->first()->delete();

        return redirect()->back();
    }
}
