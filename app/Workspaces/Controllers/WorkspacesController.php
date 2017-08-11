<?php

namespace App\Workspaces\Controllers;

use App\Workspaces\Models\Workspace;
use App\Core\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Users\Models\User;


class WorkspacesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('workspaces');
    }

    public function getEdit(Workspace $workspace){

        return view('editWorkspace', ['workspace' => $workspace]);
    }

    public function postEdit(Request $request, Workspace $workspace)
    {
        $data = $request->input('data');

        if($data) {
            $validator = Workspace::validate($data);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'Fail',
                    'errors' => $validator->errors(),
                ]);
            }

            $workspace->fill($data);
            $workspace->save();

            return response()->json([
                'status' => 'success',
                'errors' => 'false'
            ]);
        }

        return response()->json([
            'status' => 'Fail',
            'errors' => 'No input',
        ]);
    }

    public function postCreate(Request $request) {
        // validate info
        $data = $request->input('data');
        $data['ownerID'] = Auth::id();

        $v = Workspace::validate($data);

        if($v->fails()) {
            return response()->json([
                'status' => 'Fail',
                'errors' => $v->errors(),
            ]);
        }
        // workspace information
        $workspace = Workspace::create($data);

        //attach the current user since they created the workspace;
        $workspace->attachAdminUser(Auth::id());

        $users = $request->input('users');
        //add users to workspace
        $workspace->inviteUsersByEmail($users);

        return response()->json([
           'status' => 'success',
            'errors' => null
        ]);
    }

    public function deleteWorkspace(Workspace $workspace) {
        // Delete workspace from DB
        Workspace::destroy($workspace->id);
        return redirect()->to('/workspaces')->with('status', 'Workspace Deleted');
    }

    public function getAllUsers(Request $request, $workspace = null){

        if(!$workspace){
            $user = Auth::user();
            $workspace = $user->getCurrentWorkspace();
        }else{
            $workspace = Workspace::find($workspace);
        }

        if(!$request->input('raw')){
            $users = $workspace->queryUsers()->get();

            $users = $users->transform(function($user, $key){
                return[
                    'value' => $user->id,
                    'title' => $user->email,
                    'selected' => false
                ];
            })->values();
        }else{
            $users = $workspace->queryUsersWithPrivileges()->get();
        }

        return $users;
    }

    public function getAllClients($workspace = null){
        if(!$workspace){
            $user = Auth::user();
            $workspace = $user->getCurrentWorkspace();
        }else{
            $workspace = Workspace::find($workspace);
        }

        $clients = $workspace->queryClients()->get();

        $clients = $clients->transform(function($user, $key){
            return[
                'value' => $user->id,
                'title' => $user->name,
                'selected' => false
            ];
        })->values();

        return $clients;
    }

    public function getAllProjects($workspace = null){

        if(!$workspace){
            $user = Auth::user();
            $workspace = $user->getCurrentWorkspace();
        }else{
            $workspace = Workspace::find($workspace);
        }

        $projects = $workspace->queryProjects()->get();

        $projects = $projects->transform(function($user, $key){
            return[
                'value' => $user->id,
                'title' => $user->title,
                'selected' => false
            ];
        })->values();

        return $projects;
    }

    public function addAdmin(User $user){
        $currentUser = Auth::user();
        $workspace = $currentUser->getCurrentWorkspace();
        //ToDo: Implement try catch
        $workspace->addAdmin($user);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function removeAdmin(User $user){
        $currentUser = Auth::user();
        $workspace = $currentUser->getCurrentWorkspace();
        //ToDo: Implement try catch
        $workspace->removeAdmin($user);
        return response()->json([
            'status' => 'success'
        ]);
    }
}
