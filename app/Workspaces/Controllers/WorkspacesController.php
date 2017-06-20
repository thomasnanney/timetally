<?php

namespace App\Workspaces\Controllers;

use App\Workspaces\Models\Workspace;
use App\Clients\Models\Client;
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
        // get workspaces that belong to organization
        // pass it to the view

        // Step 1: Get all the workspaces that belong to the organization
        
        // Step 2: Get all the projects that belong to each specific workspace

        // Step 3: Get all the users that belong to each specific workspace

        // Step 4: Pass it all to the view

        return view('workspaces');
    }

    public function createWorkspace() {
        // Need UserID for entry creation in DB
        $user->Auth::user();

        // validate info
        if(isset($request->data['input'])) {
            $data = $request->data['input'];
            $messages = [
                'workspaceName.required' => 'Please enter a Workspace Name',
                'description.required' => 'Please enter a Workspace Description',
            ];
            $rules = [
                'workspaceName' => 'required|string|min:1',
                'description' => 'sometimes|required|string|min:1',
            ];

            $v = Validator::make($data, $rules, $messages);

            if($v->failes()) {
                return respones()->json([
                    'status' => 'Fail',
                    'errors' => $v->errors(),
                ]);
            }

            // workspace information
            $workspace = new Workspace;
            $workspace->title = $data['name'];
            $workspace->description = $data['description'];
            $workspace->ownerID = $user->id;
            $workspace->save();
        }
    }

    public function deleteWorkspace(Workspace $workspace) {

        // Delete workspace from DB
        $workspace->delete();
        return redirect()->to('/workspaces')->with('status', 'Workspace Deleted');
    }

    public function editWorkspace(Request $request, Workspace $workspace) {

        // Validate Info
        $data = $request->all();
        $messages = array(
            'workspaceName.required' => 'required|string|min:1',
            'description.required' => 'nullable|string|min:1',
        );
        $rules = array(
            'workspaceName.required' => 'Please enter a name for the workspace',
            'description.string' => 'Please enter a description for the workspace',
        );

        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails()) {
            return response()->json([
                'errors' => 'true',
                'messages' => $validator->errors(),
                'status' => 'fail'
            ]);
        }
        
        // Edit workspace Info
        $workspace->name = $request->input['name'];
        $workspace->description = $request->input['description'];
        $workspace->save();

        return response()->json([
            'errors' => 'false'
        ]);
    }
}
