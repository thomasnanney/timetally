<?php
namespace App\Projects\Models;
use Illuminate\Database\Eloquent\Model;
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