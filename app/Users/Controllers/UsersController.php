<?php

namespace App\Users\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Projects\Models\Project;
use App\Workspaces\Models\Workspace;

class UsersController extends Controller
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
        return view('users');
    }

    public function postGetClientsByUser(){
        $user =Auth::user();

        $clients = $user->getAllClients();

        return $clients;
    }

    public function postGetAllProjectsByUser(){
        $user = Auth::user();

        return $user->getAllProjectsByUser();
    }

    public function postGetAllWorkspacesByUser(){
        $user = Auth::user();

        return $user->queryWorkspaces()->get();
    }

    public function postGetAllTimeEntriesByUser(){
        $user = Auth::user();

        $timeEntries =  $user->queryTimeEntries()->where('workspaceID', '=', $user->current_workspace_id)->get();

        return $timeEntries->groupBy(function($entry){
            return date('Y-m-d', strtotime($entry->startTime));
        })->transform(function($entries){
           $subEntries = collect($entries);
           return $entries->sortByDesc(function($entry){
               return date('Y-m-d h:i', strtotime($entry['startTime']));
           })->values();
        })->sortByDesc(function($entry, $key){
            return date('Y-m-d', strtotime($key));
        });
        
    }

    public function postGetCurrentWorkspaceByUser(){
        $user = Auth::user();
        return $user->getCurrentWorkspace();
    }

    public function postMakeWorkspaceActive(Workspace $workspace){
        if($workspace){
            $user = Auth::user();
            $user->makeWorkspaceActive($workspace);
            return response('success', 200);
        }

        return response('invalid workspace', 401);
    }
}
