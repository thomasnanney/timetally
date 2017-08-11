<?php

namespace App\Users\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;
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

    public function postGetAllTimeEntriesByUser(Request $request){
        $user = Auth::user();

//        var_dump($request->get('timezone'));
        $timezone = $request->get('timezone');

        $timeEntries =  $user->queryTimeEntries()->where('workspaceID', '=', $user->current_workspace_id)->get();

        return $timeEntries->groupBy(function($entry) use($timezone){
            $date = new DateTime($entry->startTime);
            $date->setTimezone(new DateTimeZone($timezone));
            return $date->format('Y-m-d');
        })->transform(function($entries) use($timezone){
           return $entries->map(function($entry) use($timezone){
               $formattedStartTime = new DateTime($entry->startTime);
               $formattedStartTime->setTimezone(new DateTimeZone($timezone));

               $formattedEndTime = new DateTime($entry->endTime);
               $formattedEndTime->setTimezone(new DateTimeZone($timezone));

               $formattedTotalTime = $formattedEndTime->diff($formattedStartTime);
               if($formattedTotalTime->d > 0){
                   $hours = ($formattedTotalTime->d * 24) +$formattedTotalTime->h;
                   $formattedTotalTime = $hours.':'.$formattedTotalTime->format('%I');
               }else{
                   $formattedTotalTime = $formattedTotalTime->format('%H:%I');
               }

               $entry['formattedStartTime'] = $formattedStartTime->format('H:i A');
               $entry['formattedEndTime'] = $formattedEndTime->format('H:i A');
               $entry['formattedTotalTime'] = $formattedTotalTime;

               return $entry;
           })->sortByDesc(function($entry){
               //not translating these to user time zone because it is just for ordering
               return new DateTime($entry->startTime);
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
