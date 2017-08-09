<?php

namespace App\Timer\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Projects\Models\Project;
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
        return view('timer');
    }

    public function postDelete(TimeEntries $entry) {
        if($entry){
            TimeEntries::destroy($entry->id);
            return response(200)->json([
                'status' => 'success'
            ]);
        }

        return response('Invalid time entry', 404);
    }

    public function postCreate(Request $request) {
        $data = $request->input('data');

        $user = Auth::user();

        $data['startTime'] = date("Y-m-d h:i:s",strtotime($data['startTime']));
        $data['endTime'] = date("Y-m-d h:i:s",strtotime($data['endTime']));
        $data['userID'] = $user->id;
        $data['workspaceID'] = $user->current_workspace_id;
        $data['clientID'] = Project::find($data['projectID'])->clientID;

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

    /**
     * @param $request incoming data
     * @param $time entry of the user to be deleted
     * @return redirect
     */
    public function postEdit(Request $request, TimeEntries $timeEntry)
    {

        $data = $request->input('data');

        $v = TimeEntries::validate($data);

        if ($v->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => 'true',
                'messages' => $v->errors()
            ]);
        }

        $timeEntry->fill($data);
        $timeEntry->save();

        return response()->json([
            'status' => 'success',
            'errors' => 'false',
        ]);
    }

}
