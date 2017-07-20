<?php

namespace App\Users\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Projects\Models\Project;

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

        $timeEntries =  $user->queryTimeEntries()->get();

        $returnEntries = [];

        foreach($timeEntries as $entry){
            if(!isset($returnEntries[date('Y-m-d', strtotime($entry->startTime))])){
                $returnEntries[date('Y-m-d', strtotime($entry->startTime))] = [];
            }
            $entry['project_name'] = Project::find($entry->projectID)->title;
            array_push($returnEntries[date('Y-m-d', strtotime($entry->startTime))], $entry);
        }

        krsort($returnEntries);

        return $returnEntries;
    }
}
