<?php

namespace App\Clients\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Workspaces\Models\Workspace;
use Illuminate\Support\Facades\Auth;

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

    public function queryProjectsByUsersWorkspaces(){
        $user = Auth::user();
        $workspaces = $user->queryWorkspaces()->select('workspaces.id')->get();
        return $this->queryProjects()->whereIn('workspaceID', $workspaces);
    }


    public static function validate($data){
        $rules = array (
            'name' => 'required|string|min:1',
            'email' => 'required|email',
            'address1' => 'required|string|min:1',
            'address2' => 'nullable|string',
            'city' => 'required|string|min:1',
            'state' => 'required|string|min:1',
            'postalCode' => 'required|regex:/^[0-9]{5}(-[0-9]{4}){0,1}$/',
            'description' => 'nullable|string|min:1'
        );

        $messages = array(
            'name.required' => 'Please enter a Client Name',
            'email.required' => 'Please enter an eMail',
            'email.email' => 'Please enter a valid eMail',
            'address1.required' => 'Please enter an Address',
            'address2.required' => 'Please enter an Address2',
            'city.required' => 'Please enter a City',
            'state.required' => 'Please enter a State',
            'postalCode.required' => 'Please enter a Postal Code',
            'postalCode.regex' => 'Please enter a valid Postal Code. xxxxx[-xxxx]',
            'description.required' => 'Please enter a description'
        );

        return Validator::make($data, $rules, $messages);
    }
}
