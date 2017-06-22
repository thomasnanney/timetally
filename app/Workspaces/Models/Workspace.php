<?php
namespace App\Workspaces\Models;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    //set fillable and guarded
    protected $fillable = array(
        'name',
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

    public static function updateWorkspace( array $data, $id) {

        //error messages
        $messages = array(
            'name.required' => 'Please enter a Company Name',
            'description.required' => 'Please enter a Description',
            'organizationID.required' => 'Please enter an Organziation ID'
        );

        //rules
        $rules = array(
            'name' => 'required|string|min:1',
            'description' => 'nullable|string|min:1',
            'organizationID' => 'sometimes|required|int'
        );

        $validator = Validator::make($data, $rules, $messages);


        if ($validator->fails()){
            return response()->json([
                'errors' => 'true',
                'messages' => $validator->errors(),
                'status' => 'fail'
            ]);
        }

        //workspace information
        $workspace = Workspace::find($id);
        $workspace->name = $request->input('name');
        $workspace->description = $request->input('description');
        $workspace->organizationID = $request->input('organizationID');
        $workspace->save();
        return response()->json([
            'errors' => 'false'
        ]);
    }

    public static function workspaceValidator( array $data) {

        // error messages
        $messages = array(
            'name.required' => 'Please enter a Company Name',
            'description.required' => 'Please enter a Description',
            'organizationID.required' => 'Please enter an Organziation ID'
        );

        //rules
        $rules = array(
            'name' => 'required|string|min:1',
            'description' => 'nullable|string|min:1',
            'organizationID' => 'sometimes|required|int'
        );

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
        
    }
}