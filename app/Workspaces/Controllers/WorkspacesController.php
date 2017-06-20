<?php

namespace App\Workspaces\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;

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

    public function updateWorkspace(Request $request, $id)
    {
        $data = $request->all();

        //error messages
        $messages = array(
            'name.required' => 'Please enter a Company Name',
            'description.required' => 'Please enter a Description',
            'organizationID.required' => 'Please enter an Organziation ID'
        );

        //rules
        $rules = array(
            'name' => 'required|string|min:1',
            'description' => 'nullable|string|min:1',
            'organizationID' => 'sometimes|required|int'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()){
            return response()->json([
                'errors' => 'true',
                'messages' => $validator->errors(),
                'status' => 'fail'
            ]);
        }

        //workspace information
        $workspace = Workspace::find($id);
        $workspace->name = $request->input('name');
        $workspace->description = $request->input('description');
        $workspace->organizationID = $request->input('organizationID');
        $workspace->save();
        return response()->json([
            'errors' => 'false'
        ]);

    }
}
