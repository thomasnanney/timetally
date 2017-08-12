<?php

namespace App\Auth\Controllers;

use App\Users\Models\User;
use App\Workspaces\Models\WorkspaceInvite;
use App\Workspaces\Models\Workspace;
use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname => required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        if(is_null($data['token'])){

            $user = User::create([
                'name' => $data['firstname'] . " " . $data['lastname'],
                'email' => $data['email'],
                'current_workspace_id' => 0,
                'password' => bcrypt($data['password']),
            ]);

            $workspace = Workspace::create([
                'name' => $data['firstname'] . "'s Workspace",
                'ownerID' => $user->id,
                'description' => 'Please edit this description',
            ]);

            $user->current_workspace_id = $workspace->id;
            $user->save();
            $workspace->attachAdminUser($user->id);
        }else{
            $invite = WorkspaceInvite::where('token', '=', $data['token'])->first();

            $user = User::create([
                'name' => $data['firstname'] . " " . $data['lastname'],
                'email' => $data['email'],
                'current_workspace_id' => $invite->workspaceID,
                'password' => bcrypt($data['password']),
            ]);

            $workspace = Workspace::find($invite->workspaceID);
            $workspace->attachRegularUser($user->id);

            $invite->delete();
        }

        return $user;

    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm($token = null)
    {

        if($token){
            $invite = WorkspaceInvite::where('token', '=', $token)->exists();
            if($invite){
                return view('register')->with('token', $token);
            }
            return view('inviteExpired');
        }

        return view('register')->with('token', $token);
    }
}
