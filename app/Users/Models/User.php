<?php

namespace App\Users\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addUserToWorkspace($workspaceID) {
        if(!(DB::table('user_workspace_pivot')
            ->where('workspaceID', '=', $workspaceID)
            ->where('userID', '=', $this->id)
            ->exists())
        ) {
            DB::table('user_workspace_pivot')->insert([
                'userID' => $this->id,
                'workspaceID' => $workspaceID,
            ]);
        }
    }
}
