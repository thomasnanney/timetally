<?php

namespace App\Workspaces\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Workspaces\Models\Workspace;
use App\Workspaces\Models\WorkspaceInvite;

class WorkspaceInviteController extends Controller
{
    public function getInvite(){
        return view('invite');
    }

    public function postInvite(Request $request, Workspace $workspace){
        // validate the incoming request data

        $data = $request->input('data');

        if(isset($data)){

            $validator = WorkspaceInvite::validate($data);

            if($validator->fails()){
                return reponse()->json([
                    'status' => 'fail',
                    'errors' => $validator->errors(),
                ]);
            }else{
                WorkspaceInvite::sendInvite($data['email'], $workspace->id);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Invite sent to the email provided.'
                ]);
            }

        }else{
            // redirect back where we came from
            return response()->json([
                'status' => 'fail',
                'errors' => 'Something went wrong.'
            ]);
        }


    }
}
