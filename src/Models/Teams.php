<?php
/**
 * Teams Model
 */
namespace Roelvanlierop\Usermanager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * Teams Model
 *
 * Teams model, for handling named teams in Spatie's Laravel Permissions
 *
 * @package Roelvanlierop\Usermanager\Models
 * @author Roel van Lierop | Lead Developer
 * @category Laravel Model class
 */
class Teams extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_name'
    ];

    /**
     * User listing method.
     *
     * Retrieve user list for current Teams Model
     *
     * @return Collection Eloquent collection with the users associated with a team.
     */
    public function hasUsers (): Collection
    {
        $memberships = DB::table('model_has_roles')->select('model_id')
        ->where( 'model_type', '=', 'App\Models\User' )
        ->where( 'team_id', '=', $this->id )
        ->distinct()->get()->pluck('model_id')->toArray();

        return User::whereIn( 'id', $memberships )->get();
    }
}
