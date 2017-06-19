<?php

namespace App\Clients\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{


    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'address1',
        'address2',
        'city',
        'state',
        'postalCode',
        'description'
    ];


    public function getWorkspaces(){
        return $this->belongsToMany('App\Workspaces\Models\Workspace',
            'client_workspace_pivot',
            'clientID',
            'workspaceID');
    }
}
