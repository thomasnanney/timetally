<?php
namespace App\Timer\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class TimeEntries extends Model {

    //set fillable and guarded
    protected $fillable = array(
        'workspaceID',
        'projectID',
        'userID',
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
        var_dump($tempData);

        $messages = [
            'description.required' => 'Please enter a description',
            'projectID.required' => 'Please enter a Project Name',
            'startTime.required' => 'Please enter a Start Date',
            'endTime.required' => 'Please enter an End Date',
            'billableType.required' => 'Please enter Billable Type',
        ];
        $rules = [
            'description' => 'required|string|min:1',
            'clientID' => 'required|integer|exists:clients,id', // needs to exist
            'userID' => 'required|integer|exists:users,id', // needs to exist
            'projectID' => 'required|integer|exists:projects,id', // needs to exist
            'workspaceID' => 'required|integer|exists:workspaces,id', // needs to exist
            'startTime' => 'required',
            'endTime' => 'required',
            'billable' => 'sometimes|integer',
        ];

        return Validator::make($tempData, $rules, $messages);
    }


}