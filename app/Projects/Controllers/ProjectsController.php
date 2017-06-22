<?php

namespace App\Projects\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Projects\Models\Project;
use Illuminate\Support\Facades\Auth;

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

        $v = Project::validate($data);

        if($v->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => 'true',
                'messages' => $v->errors(),
            ]);
        }

        $project = Project::create($data);

        //since project was created, link the current user
        $project->queryUsers()->attach(Auth::user()->id);

        return response()->json([
           'status' => 'success',
            'errors' => 'false'
        ]);
    }

    public function deleteProject($id) {
        if(Project::find($id)){
            Project::destroy($id);
            return response()->json([
               'status' => 'success',
                'errors' => 'false'
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'errors' => 'true',
            'messages' => [
                'Unable to find project'
            ]
        ]);
    }

    public function getEdit(Project $project){
        return view('viewProject', ['project' => $project]);
    }

    /**
     * Update the project scope
     * @param $request incoming data
     * @param $project of the client to be deleted
     * @return redirect
     */
    public function postEdit(Request $request, Project $project)
    {

        $data = $request->input('data');

        $v = Project::validate($data);

        if ($v->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => 'true',
                'messages' => $v->errors()
            ]);
        }

        $project->fill($data);
        $project->save();

        return response()->json([
            'status' => 'success',
            'errors' => 'false',
        ]);
    }

    public function getUsers(Project $project){
        return $project->queryUsers()->get();
    }

}