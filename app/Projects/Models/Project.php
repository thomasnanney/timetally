<?php
namespace App\Projects\Models;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Project extends Model
{
    //set fillable and guarded
    protected $fillable = array(
        'description',
        'clientID',
        'billableType',
        'projectedRevenue',
        'title',
        'startDate',
        'endDate',
        'projectedTime',
        'scope',
        'billableHourlyType',
        'billableRate',
        'workspaceID'
    );

    public static function validate($data){

        $tempData = array_filter($data, function($value){
            return !is_null($value);
        });

        $messages = [
            'title.required' => 'Please enter a Project Title',
            'clientID.required' => 'Please enter a Client Name',
            'startDate.required' => 'Please enter a Start Date',
            'endDate.required' => 'Please enter an End Date',
            'billableType.required' => 'Please enter Billable Type',
        ];
        $rules = [
            'title' => 'required|string|min:1',
            'description' => 'sometimes|string|min:1',
            'clientID' => 'required|integer|exists:clients,id', // needs to exist
            'workspaceID' => 'required|integer|exists:workspaces,id',
            'startDate' => 'required',
            'endDate' => 'required',
            'projectedTime' => 'required|integer|',
            'projectedRevenue' => 'required|numeric',
            'billableType' => 'required|string|min:1',
        ];

        return Validator::make($tempData, $rules, $messages);
    }

    public function queryUsers() {
        return $this->belongsToMany('App\Users\Models\User', 'project_user_pivot', 'projectID', 'userID');
    }

    /**
     * add a user to a project with the project_user_pivot table
     * @param $userID id of user to be added to the project
     */
    public function addUser(User $user) {
        $this->queryUsers()->attach($user->id);
    }

    public function removeUser(User $user){
        $this->queryUsers()->detach($user->id);
    }

    public static function deleteProject($id){
        Project::destroy($id);
        return response()->json([
            'status' => 'success'
        ]);
    }
}