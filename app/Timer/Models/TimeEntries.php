<?php
namespace App\Timer\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class TimeEntries extends Model {

    //set fillable and guarded
    protected $fillable = array(
        'projectID',
        'userID',
        'workspaceID',
        'clientID',
        'startTime',
        'endTime',
        'description',
        'billable'
    );

    public static function validate($data){

        $tempData = array_filter($data, function($value){
            return !is_null($value);
        });

        $messages = [
            'description.required' => 'Please enter a description',
            'projectID.required' => 'Please choose a project',
            'workspaceID.required' => 'Please enter a Workspace Name',
            'startTime.required' => 'Please enter a start date',
            'endTime.required' => 'Please enter an end date',
            'billableType.required' => 'Please enter billable type',
        ];
        $rules = [
            'description' => 'required|string|min:1',
            'userID' => 'required|integer|exists:users,id', // needs to exist
            'projectID' => 'required|integer|exists:projects,id', // needs to exist
            'workspaceID' => 'required|integer|exists:workspaces,id',//needs to exist
            'startTime' => 'required',
            'endTime' => 'required',
            'billableType' => 'sometimes|integer',
        ];

        return Validator::make($tempData, $rules, $messages);
    }

    public function queryUsers(){
        return $this->belongsTo('App\Users\Models\User', 'userID');
    }

    public function queryWorkspaces(){
        $this->belongsTo('App\Workspaces\Model\Workspace','workspaceID');
    }

    public function queryProjects(){
        $this->belongsTo('App\Projects\Model\Project', 'projectID');
    }


}