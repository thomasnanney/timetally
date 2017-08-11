<?php

namespace App\Projects\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Projects\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Users\Models\User;

class ProjectsController extends Controller
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
        return view('projects');
    }

    public function getCreate(){
        return view('addProject');
    }

    public function postCreate(Request $request) {

        $data = $request->input('data');
        $user = Auth::user();
        $data['workspaceID'] = $user->getCurrentWorkspace()->id;

        $v = Project::validate($data);

        if($v->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => 'true',
                'messages' => $v->errors(),
            ]);
        }

        $project = Project::create($data);

        //attach the current user if the project is private
        if($project->private){
            $project->queryUsers()->attach(Auth::user()->id);

            //also attach users supplied
            $users = $request->get('users');

            //ToDo: If user does not exist we need to noitfy and offer the opportunitty to invite
            foreach($users as $userEmail){
                if(gettype($userEmail) == 'string'){
                    $user = User::where('email', '=', $userEmail)->first();
                    if($user){
                        $project->addUser($user);
                    }
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'errors' => 'false',
        ]);
    }

    public function deleteProject($id) {
        if(Project::find($id)){
            Project::destroy($id);
            return response()->json([
                'status' => 'success',
                'errors' => 'false',
                'messages' => [
                    'Project deleted'
                ]
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'errors' => 'true',
            'messages' => [
                'Project not found'
            ]
        ]);
    }

    public function getEdit(Project $project){
        return view('viewProject', ['project' => $project]);
    }

    /**
     * Update an existing project
     *
     * @param $request incoming data
     * @param $project to be edited
     * @return redirect
     */
    public function postEdit(Request $request, Project $project)
    {

        $data = $request->input('data');
        $user = Auth::user();
        $data['workspaceID'] = $user->getCurrentWorkspace()->id;

        $v = Project::validate($data);

        if ($v->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => 'true',
                'messages' => $v->errors()
            ]);
        }

        $project->fill($data);

        if($project->private){
            //also attach users supplied
            $users = $request->get('users');

            foreach($users as $userEmail){
                if(gettype($userEmail) == 'string'){
                    $user = User::where('email', '=', $userEmail)->first();
                    if($user){
                        $project->addUser($user);
                    }
                }
            }
        }else{
            $project->makePublic();
        }

        $project->save();

        return response()->json([
            'status' => 'success',
            'errors' => 'false',
            'messages' => 'Project successfully updated'
        ]);
    }

    public function getUsers(Project $project){
        return $project->queryUsers()->get();
    }

    public function addUser(Project $project, User $user){
        $project->addUser($user);

        return response()->json([
            'status' => 'success',
            'errors' => 'false',
            'messages' => 'User added'
        ]);
    }

    public function removeUser(Project $project, User $user){
        $project->removeUser($user);

        return response()->json([
            'status' => 'success',
            'errors' => 'false',
            'messages' => 'User removed'
        ]);
    }

}