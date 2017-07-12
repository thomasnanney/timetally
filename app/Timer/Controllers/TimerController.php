<?php

namespace App\Timer\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Projects\Models\Project;
use App\Workspaces\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use App\Timer\Models\TimeEntries;

class TimerController extends Controller
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
        $user = Auth::user();

        // get workspace user belongs to
        $workspace = DB::table('user_workspace_pivot')->where('userID', '=', $user->id)->first();

        // get all projects from workspace user belongs to
        $userProjects = Projects::where('workspaceID', '=', $workspace->workspaceID);

        //  get all time entries created by user
        $entries = TimeEntries::where('userID', '=', $user->id);


        return view('timer',
            [
                'entries' => $entries,
                'user' => $user,
                'projects' => $userProjects,
            ]);
    }

    public function deleteTimeEntry($id) {
        if(TimeEntries::find($id)){
            TimeEntries::destroy($id);
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

    public function postCreate(Request $request) {
        $data = $request->input('data');

        $v = TimeEntries::validate($data);

        if($v->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => 'true',
                'messages' => $v->errors(),
            ]);
        }

        TimeEntries::create($data);


        return response()->json([
            'status' => 'success',
            'errors' => 'false'
        ]);
    }


}
