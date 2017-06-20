<?php

namespace App\Clients\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{


    /**
     * @var array Fields that are mass assignable
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany Pivot table relationship
     */
    public function queryWorkspaces(){
        return $this->belongsToMany('App\Workspaces\Models\Workspace',
            'client_workspace_pivot',
            'clientID',
            'workspaceID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Has foreign key in Projects table
     */
    public function queryProjects(){
        return $this->hasMany('App\Projects\Models\Project', 'clientID');
    }
}
