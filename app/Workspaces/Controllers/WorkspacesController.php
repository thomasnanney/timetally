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
                    'errors' => $validator->errors(),
                ], 400);
            }

            $workspace->fill($data);
            $workspace->save();

            return response('Workspace saved', 200);
        }

        return response('Invalid input', 400);
    }

    public function postCreate(Request $request) {
        // validate info
        $data = $request->input('data');
        $data['ownerID'] = Auth::id();

        $v = Workspace::validate($data);

        if($v->fails()) {
            return response()->json([
                'errors' => $v->errors(),
            ], 400);
        }
        // workspace information
        $workspace = Workspace::create($data);

        //attach the current user since they created the workspace;
        $workspace->attachAdminUser(Auth::id());

        $users = $request->input('users');
        //add users to workspace
        $workspace->inviteUsersByEmail($users);

        return response('Workspace created', 201);
    }

    public function leaveWorkspace(Request $request, Workspace $workspace){
        try{
            $user = $request->user();
            if($workspace->id == $user->current_workspace_id){
                return response('Can not delete active workspace', 409);
            }
            $workspace->queryUsers()->detach($user->id);
            return response('Success', 200);
        }catch(Exception $e){
            return response('Fail', 400);
        }
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

    public function addAdmin(Request $request, User $user){
        $currentUser = $request->user();
        $workspace = $currentUser->getCurrentWorkspace();
        //ToDo: Implement try catch
        try{
            $workspace->addAdmin($user);
        }catch(Exception $e){
            return response('Fail', 400);
        }
        return response('Success', 200);
    }

    public function removeAdmin(Request $request, User $user){
        $currentUser = $request->user();
        $workspace = $currentUser->getCurrentWorkspace();
        //ToDo: Implement try catch
        try{
            $workspace->removeAdmin($user);
        }catch(Exception $e){
            return response('Fail', 400);
        }
        return response('Success', 200);
    }
}
