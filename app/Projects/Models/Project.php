<?php
namespace App\Projects\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Project extends Model
{
    //set fillable and guarded
    protected $fillable = array(
        'id',
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
        'billableRate'
    );

    public static function validate($data){
        $messages = [
            'projectTitle.required' => 'Please enter a Project Title',
            'description.required' => 'Please enter a Project Description',
            'clientName.required' => 'Please enter a Client Name',
            'startDate.required' => 'Please enter a Start Date',
            'endDate.required' => 'Please enter an End Date',
            'projectedRevenue.required' => 'Please enter Projected Revenue',
            'projectedTime.required' => 'Please enter Projected Time',
            'billableType.required' => 'Please enter Billable Type',
        ];
        $rules = [
            'projectTitle' => 'required|string|min:1',
            'description' => 'sometimes|required|string|min:1',
            'clientName' => 'required|string|min:1', // needs to be different
            'startDate' => 'required|string|min:1',
            'endDate' => 'required|string|min:1',
            'projectedTime' => 'required|integer|',
            'projectedRevenue' => 'required|decimal',
            'billableType' => 'sometimes|required|string|min:1',
        ];

        return Validator::make($data, $rules, $messages);
    }

    public function queryUsers() {
        return $this->belongsToMany('App\Users\Models\User', 'project_user_pivot', 'projectID', 'userID');
    }

    /**
     * add a user to a project with the project_user_pivot table
     * @param $userID id of user to be added to the project
     */
    public function addUserToProject($userID) {
        if(!(DB::table('project_user_pivot')
            ->where('usertID', '=', $userID)
            ->where('projectID', '=', $this->id)
            ->exists())
        ) {
            DB::table('project_user_pivot')->insert([
                'userID' => $userID,
                'projectID' => $this->id,
            ]);
        }


    }

    public static function deleteProject($id){
        Project::destroy($id);
        return response()->json([
            'status' => 'success'
        ]);
    }
}