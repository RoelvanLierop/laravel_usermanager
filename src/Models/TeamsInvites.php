<?php

namespace Roelvanlierop\Usermanager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamsInvites extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team_id',
        'role_id',
        'invite_email',
        'invite_date'
    ];
}
