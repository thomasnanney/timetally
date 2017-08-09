<?php

namespace App\Workspaces\Models;

use App\Mail\Invite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class WorkspaceInvite extends Model
{

    protected $fillable = [
        'email',
        'workspaceID',
        'token',
        ];

    public static function sendInvite($email, $workspaceID){
        do{
            $token = str_random(32);
        }while(WorkspaceInvite::where('token', $token)->first());

        $invite = WorkspaceInvite::create([
            'email' => $email,
            'workspaceID' => $workspaceID,
            'token' => $token,
        ]);

        Mail::to($email)->send(new Invite($invite));



    }

    public static function validate( array $data) {

        // error messages
        $messages = array(
            'email.require' => 'Please provide an email',
            'email.email' => 'Please enter a valid email',
        );

        //rules
        $rules = array(
            'email' => 'required|email',
        );

        $validator = Validator::make($data, $rules, $messages);

        return $validator;

    }
}
