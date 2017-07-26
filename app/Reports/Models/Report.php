<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/25/17
 * Time: 11:17 AM
 */

namespace App\Reports\Models;

use Illuminate\Support\Facades\Auth;


class Report
{
    public static function generateReport($data, $user){
        $clientFilter = array_get($data, 'filters.client');
        $projectFilter = array_get($data, 'filters.project');
        $userFilter = array_get($data, 'filters.user');
        $dateRange = array_get($data, 'filters.dateRange');
        $groupBy = array_get($data, 'groupBy');
        $subGroup = array_get($data, 'subGroup');
        $subGroupBy = array_get($data, 'subGroupBy');

        //$user = Auth::user();

        $workspace = $user->current_workspace_id;

        $timeEntries = $user->queryTimeEntries()->join('users', 'time_entries.userID', '=', 'users.id')
            ->join('workspaces', 'time_entries.workspaceID', '=', 'workspaces.id')
            ->join('projects', 'time_entries.projectID', '=', 'projects.ID')
            ->select('time_entries.title', 'time_entries.description', 'time_entries.startTime',
                'time_entries.workspaceID', 'time_entries.projectID', 'time_entries.userID',
                'users.name', 'workspaces.title', 'projects.title')->get();

        if($clientFilter != null){
           // $timeEntries->whereIn('clientID', $clientFilter);
        }
        if($projectFilter != null){
           // $timeEntries->whereIn('projectID', $projectFilter);
        }
        if($userFilter != null){
            //$timeEntries->whereIn('userID', $userFilter);
        }
        if($dateRange == null){
            $startDate = strtotime('Monday this week');
            $endDate = strtotime('now');
            $timeEntries->where('time_entries.startTime', '>=', $startDate)
                ->where('time_entries.endTime', '<=', $endDate);
        }else{
           // $timeEntries->where('time_entries.startTime', '>=', '');
        }
        if($groupBy == 'Client'){
            //$timeEntries->orderBy('time_entries.clientID');
        }
        if($groupBy == 'Project'){
            $timeEntries->orderBy('time_entries.projectID');
        }
        if($groupBy == 'User'){
            $timeEntries->orderBy('time_entries.projectID');
        }
        //$timeEntries->get();
        return $timeEntries;







    }
}