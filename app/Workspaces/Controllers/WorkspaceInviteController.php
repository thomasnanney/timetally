<?php

namespace App\Workspaces\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Workspaces\Models\Workspace;
use App\Workspaces\Models\WorkspaceInvite;

class WorkspaceInviteController extends Controller
{

    public function inviteUsers(Workspace $workspace, Request $request){
        $users = $request->input('data');

        try{
            $workspace->inviteUsersByEmail([$users]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'errors' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function postInvite(Request $request, Workspace $workspace){

        // validate the incoming request data
        $data = $request->input('data');
        if(isset($data)){
            $validator = WorkspaceInvite::validate($data);

            if($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors(),
                ], 400);
            }

            $workspace->inviteUsersByEmail($data);

            return response('Successfully invited user(s)', 201);
        }

        // redirect back where we came from
        return response('Invalid request', 400);
    }

    public function getConfirmInvitation($token = null){
        if($token){
            $invite = WorkspaceInvite::where('token', '=', $token)->first();
            if($invite){
                $invite->confirm();
                return view('login');
            }
            return view('inviteExpired');
        }
        return redirect('/');
    }
}
