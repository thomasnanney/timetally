<?php

namespace App\Users\Models;

use App\Workspaces\Models\Workspace;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Clients\Models\Client;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'current_workspace_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = [
        'id'
    ];

    public function queryWorkspaces(){
        return $this->belongsToMany('App\Workspaces\Models\Workspace', 'user_workspace_pivot', 'userID', 'workspaceID');
    }

    public function getAllClients(){
        $workspace = $this->getCurrentWorkspace();

        return $workspace->queryClients()->get();
    }

    public function getAllProjectsByUser(){

        //get pulic projects for workspace and private projects and merge then return
        $publicProjects = $this->queryPublicProjects()->get();
        $privateProjects = $this->queryPrivateProjects()->where('workspaceID', '=', $this->current_workspace_id)->get();

        return $publicProjects->merge($privateProjects)->sortBy('title')->values();
    }

    public function getCurrentWorkspace(){
        return Workspace::find($this->current_workspace_id);
    }

    public function makeWorkspaceActive(Workspace $workspace){
        $this->current_workspace_id = $workspace->id;
        $this->save();
    }

    public function queryPublicProjects(){
        return $this->getCurrentWorkspace()->queryProjects()->where('scope', '=', 'public');
    }

    public function queryPrivateProjects(){
        return $this->belongsToMany('App\Projects\Models\Project', 'project_user_pivot', 'userID', 'projectID');
    }

    public function queryTimeEntries(){
        return $this->hasMany('App\Timer\Models\TimeEntries', 'userID', 'id');
    }

    public function queryTimeEntriesByWorkspace($workspaceId){
        return $this->queryTimeEntries()->where('workspaceID', $workspaceId);
    }

    public function isAdmin(){
        return DB::table('user_workspace_pivot')
            ->where('userID', '=', $this->id)
            ->where('workspaceID', '=', $this->current_workspace_id)
            ->value('admin');
    }
}
