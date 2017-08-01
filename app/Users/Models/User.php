<?php

namespace App\Users\Models;

use App\Workspaces\Models\Workspace;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Clients\Models\Client;

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
        $workspaces = $this->queryWorkspaces()->get();

        $results = collect();
        foreach($workspaces as $workspace){
            $clients = $workspace->queryClients()->get();
            foreach($clients as $client){
                $results->push($client);
            }
        }

        return $results->unique('id');
    }

    public function getAllProjectsByUser(){
        $workspaces = $this->queryWorkspaces()->get();

        $results = collect();
        foreach($workspaces as $workspace){
            $projects = $workspace->queryProjects()->get();
//            $results->merge($projects);
            foreach($projects as $project){
                $project['workspaceTitle'] = Workspace::find($project->workspaceID)->title;
                $project['clientName'] = Client::find($project->clientID)->name;
                $results->push($project);
            }

        }

//        var_dump($results);

        return $results;
    }

    public function getCurrentWorkspace(){
        return $this->current_workspace_id;
    }

    public function queryProjects(){
        return $this->belongsToMany('App\Projects\Models\Project', 'project_user_pivot', 'userID', 'projectID');
    }

    public function queryTimeEntries(){
        return $this->hasMany('App\Timer\Models\TimeEntries', 'userID', 'id');
    }

    public function queryTimeEntriesByWorkspace($workspaceId){
        return $this->queryTimeEntries()->where('workspaceID', $workspaceId);
    }
}
