<?php

namespace App\Workspaces\Models;

use App\Mail\Models\InviteNewUser;
use App\Mail\Models\InviteCurrentUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Users\Models\User;

class WorkspaceInvite extends Model
{

    protected $fillable = [
        'email',
        'workspaceID',
        'token',
        ];

    public function __construct(array $attributes = [])
    {
        do{
            $token = str_random(32);
        }while(WorkspaceInvite::where('token', '=', $token)->exists());

        $attributes['token'] = $token;

        parent::__construct($attributes);

    }

    public function inviteNewUser(){
        $workspace = Workspace::find($this->workspaceID);
        Mail::to($this->email)->send(new InviteNewUser($this, $workspace));
    }

    public function inviteCurrentUser(){
        $workspace = Workspace::find($this->workspaceID);
        Mail::to($this->email)->send(new InviteCurrentUser($this, $workspace));
    }

    public function confirm(){
        $user = User::where('email', '=', $this->email)->first();
        $workspace = Workspace::find($this->workspaceID);

        $workspace->attachRegularUser($user->id);

        $this->delete();
    }

    public static function validate( array $data) {

        // error messages
        $messages = array(
            'userEmails.*.require' => 'Please provide an email',
            'userEmails.*.email' => 'Please enter a valid email',
        );

        //rules
        $rules = array(
            'userEmails.*' => 'required|email',
        );

        $validator = Validator::make($data, $rules, $messages);

        return $validator;

    }
}
