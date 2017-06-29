<?php

namespace App\Workspaces\Controllers;

use App\Workspaces\Models\Workspace;
use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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

    public function getEdit(){
        return view('editWorkspace');
    }

    public function postEdit(Request $request, Workspace $workspace)
    {
        $data = $request->input('data');

        if(isset($request['data'])) {
            $validator = Workspace::validate($data);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'Fail',
                    'errors' => $validator->errors(),
                ]);
            }
            $workspace->name = $request->input('name');
            $workspace->description = $request->input('description');
            $workspace->organizationID = $request->input('organizationID');
            $workspace->save();
            return response()->json([
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

        $v = Workspace::validate($data);

        if($v->fails()) {
            return response()->json([
                'status' => 'Fail',
                'errors' => $v->errors(),
            ]);
        }

        // workspace information
        Workspace::create($data);

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
}
