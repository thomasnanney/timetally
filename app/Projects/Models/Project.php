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

    /**
     * Validate the incoming data to ensure it
     * matches the required specifications.
     *
     * @param $data array of incoming data
     * @return Validator returns function fails() or passes() based
     *          based on specified rules.
     */
    public static function validate($data){

        $data = array_filter($data, function($value){
            return !is_null($value);
        });

//        var_dump($data);

        $messages = [
            'title.required' => 'Please enter a Project Title',
            'clientID.required' => 'Please enter a Client Name',
            'workspaceID.required' => 'Please enter a Workspace Name',
            'startDate.required' => 'Please enter a Start Date',
            'startDate.before' => 'A project must start before it ends!',
            'endDate.required' => 'Please enter an End Date',
            'billableType.required' => 'Please enter Billable Type',
            'scope.required' => 'Please enter the Project as Private or Public',
            'projectedTime.required' => "Please entered a projected time",
            'projectedRevenue.required' => "Please entered a projected Revenue",
            'projectedRevenue.regex' => "Projected Revenue must be a dollar amount",
            'billableRate.required' => "Please entered an hourly billable rate",
            'billableRate.regex' => "Hourly billable rate must be a dollar amount",
        ];
        $rules = [
            'title' => 'required|string|min:1',
            'description' => 'sometimes|string|min:1',
            'clientID' => 'required|integer|exists:clients,id', // needs to exist
            'workspaceID' => 'required|integer|exists:workspaces,id',
            'startDate' => 'required|date_format:"Y-m-d"',
            'endDate' => 'required|date_format:"Y-m-d"', //must be in YYYY-MM-DD format and come after the start date
            'projectedTime' => 'required|integer',
            'billableType' => 'required|string|in:hourly,fixed', //must be hourly or fixed
            'scope' => 'required|string|in:public,private', //must be public or private
        ];

        $v = Validator::make($data, $rules, $messages);

        if(array_key_exists('endDate', $data)){
            $v->sometimes('startDate', 'before:'.$data['endDate'], function(){
                return true;
            });
        }

        //conditional validation
        $v->sometimes('projectedRevenue', 'required|regex:/^\d+(\.\d\d)?$/', function($data){
            return $data['billableType'] == 'fixed';
        });

        $v->sometimes('billableRate', 'required|regex:/^\d+(\.\d\d)?$/', function($data){
            return $data['billableType'] == 'hourly' && $data['billableHourlyType'] == 'project';
        });

        return $v;
    }

    public function queryUsers() {
        return $this->belongsToMany('App\Users\Models\User', 'project_user_pivot', 'projectID', 'userID');
    }

    /**
     * Add a user to a project by updating
     * the project_user_pivot table
     *
     * @param $user user object to be added
     */
    public function addUser(User $user) {
        $this->queryUsers()->syncWithoutDetaching($user->id);
    }

    /**
     * Remove a user from a project by updating
     * the project_user_pivot table
     *
     * @param $user user object to be removed
     */
    public function removeUser(User $user){
        $this->queryUsers()->detach($user->id);
    }

    /**
     * Delete a project from the database
     *
     * @param $id id of the project to be deleted
     */
    public static function deleteProject($id){
        Project::destroy($id);
    }
}