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
        'projectedRevenue',
        'projectedCost',
        'title',
        'startDate',
        'endDate',
        'projectedTime',
        'private',
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
            'startDate.required' => 'Please enter a Start Date',
            'startDate.before' => 'A project must start before it ends!',
            'endDate.required' => 'Please enter an End Date',
            'private.required' => 'Please set the Project as Private or Public',
            'projectedTime.required' => "Please entered a projected time",
            'projectedRevenue.required' => "Please entered the projected revenue",
            'projectedRevenue.regex' => "Projected Revenue must be a dollar amount",
            'projectedCost.required' => "Please entered the projected cost",
            'projectedCost.regex' => "Projected Revenue must be a dollar amount",
        ];
        $rules = [
            'title' => 'required|string|min:1',
            'description' => 'sometimes|string|min:1',
            'clientID' => 'required|integer|exists:clients,id', // needs to exist
            'workspaceID' => 'required|integer|exists:workspaces,id',
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d',
            'projectedTime' => 'required|integer',
            'private' => 'required|boolean', //must be public or private
            'projectedRevenue' => 'required|regex:/^\d+(\.\d\d)?$/',
            'projectedCost' => 'required|regex:/^\d+(\.\d\d)?$/'
        ];

        $v = Validator::make($data, $rules, $messages);

        if(array_key_exists('endDate', $data)){
            $v->sometimes('startDate', 'before:'.$data['endDate'], function(){
                return true;
            });
        }

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

    public function makePublic(){
        $this->queryUsers()->detach();
    }
}