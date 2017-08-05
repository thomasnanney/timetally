<?php
namespace App\Workspaces\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Workspace extends Model
{
    //set fillable and guarded
    protected $fillable = array(
        'title',
        'description',
        'ownerID',
        'organizationID'
    );

    public function queryUsers() {
        return $this->belongsToMany('App\Users\Models\User', 'user_workspace_pivot', 'workspaceID', 'userID');
    }

    public function queryProjects() {
        return $this->hasMany('App\Projects\Models\Project', 'workspaceID');
    }

    public function setOrganization() {
        // TODO: set the organization ID for the workspace
    }

    public function queryClients(){
        return $this->belongsToMany('App\Clients\Models\Client', 'client_workspace_pivot', 'workspaceID', 'clientID');
    }

    public static function validate( array $data) {

        // error messages
        $messages = array(
            'title.required' => 'Please enter a Company Name',
            'description.required' => 'Please enter a Description',
            'ownerID.required' => 'Please enter an Owner ID',
            'organizationID.required' => 'Please enter an Organziation ID'
        );

        //rules
        $rules = array(
            'title' => 'required|string|min:1',
            'description' => 'nullable|string|min:1',
            'ownerId' => 'sometimes|required|int',
            'organizationID' => 'sometimes|required|int'
        );

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
        
    }
}