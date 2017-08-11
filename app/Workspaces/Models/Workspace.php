<?php
namespace App\Workspaces\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Users\Models\User;

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

    public function queryUsersWithPrivileges(){
        return $this->belongsToMany('App\Users\Models\User', 'user_workspace_pivot', 'workspaceID', 'userID')
            ->withPivot('admin');
    }

    public function queryProjects() {
        return $this->hasMany('App\Projects\Models\Project', 'workspaceID');
    }

    public function queryClients(){
        return $this->belongsToMany('App\Clients\Models\Client', 'client_workspace_pivot', 'workspaceID', 'clientID');
    }

    public static function validate( array $data) {

        // error messages
        $messages = array(
            'name.required' => 'Please enter a Company Name',
            'description.required' => 'Please enter a Description',
            'ownerID.required' => 'Please enter an Owner ID',
            'organizationID.required' => 'Please enter an Organziation ID'
        );

        //rules
        $rules = array(
            'name' => 'required|string|min:1',
            'description' => 'nullable|string|min:1',
            'ownerID' => 'required|int|exists:users,id',
            'organizationID' => 'nullable|int|exists:organizations,id'
        );

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function setOrganization() {
        // TODO: set the organization ID for the workspace
    }

    public function attachRegularUser($userId){
        $this->queryUsers()->attach($userId, [
            'admin' => 0,
        ]);
    }

    public function attachAdminUser($userId){
        $this->queryUsers()->attach($userId, [
            'admin' => 1,
        ]);
    }

    public function addAdmin($user){
        $this->queryUsersWithPrivileges()->updateExistingPivot($user->id, ['admin' => 1]);
    }

    public function removeAdmin($user){
        $this->queryUsersWithPrivileges()->updateExistingPivot($user->id, ['admin' => 0]);
    }

    /**
     * Takes in an array of user emails and creates invitations
     * @param $users
     */
    public function inviteUsersByEmail($users){

        foreach($users as $userEmail){
            //see if user exists
            $user = User::where('email', $userEmail)->first();

            $inviteInfo = [
                'email' => $userEmail[0],
                'workspaceID' => $this->id,
            ];

            $invite = WorkspaceInvite::create($inviteInfo);

            if($user){
                //send invite to current user
                $invite->inviteCurrentUser();
            }else{
                //send invite to new user
                $invite->inviteNewUser();
            }
        }
    }

}