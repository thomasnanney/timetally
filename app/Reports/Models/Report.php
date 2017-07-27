<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 7/25/17
 * Time: 11:17 AM
 */

namespace App\Reports\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Report
{
    public static function generateReport($data, $user){
        $clientFilter = $data['filters']['client'];
        $projectFilter = $data['filters']['project'];
        $userFilter = $data['filters']['user'];
        $dateRange = $data['filters']['dateRange'];
        $groupBy = $data['groupBy'];
        $subGroup = $data['subGroup'];
        $subGroupBy = $data['subGroupBy'];

        //$user = Auth::user();


        $workspace = $user->current_workspace_id;

        $timeEntries = DB::table('timereports')->select('*')->where('workspaceID', $workspace);
        $timeEntries->where(function ($timeEntries) use ($clientFilter, $projectFilter, $userFilter) {
            if (!is_null($clientFilter)) {
                $timeEntries->orWhereIn('clientID', $clientFilter);
            }
            if (!is_null($projectFilter)) {
                $timeEntries->orWhereIn('projectID', $projectFilter);
            }
            if (!is_null($userFilter)) {
                $timeEntries->orWhereIn('userID', $userFilter);
            }
        });
        if(is_null($dateRange)){
            $startDate = Carbon::parse('Monday this week')->format('y-m-d');
            $endDate = Carbon::parse('now')->format('y-m-d');
            $timeEntries->whereBetween('startTime', [$startDate, $endDate]);
        }else{
            $startDate = Carbon::parse($dateRange['startTime'])->format('Y-m-d');
            $endDate = Carbon::parse($dateRange['endTime'])->format('Y-m-d');
            $timeEntries->whereBetween('startTime', [$startDate, $endDate]);
        }
        $timeEntries = $timeEntries->get();

        if ($groupBy == 'client') {
            if ($subGroup == 'true') {
                if ($subGroupBy == 'project') {
                    $timeEntries = $timeEntries->groupBy('clientID')->->transform(function($item, $key){return $item->groupBy('projectID');});
                }
                if ($subGroupBy == 'user') {
                    $timeEntries = $timeEntries->groupBy('clientID')->transform(function($item, $key){return $item->groupBy('userID');});
                }
            }else{
                $timeEntries = $timeEntries->groupBy('clientID');
            }
        }
        if ($groupBy == 'project') {
            if($subGroup == 'true'){
                if($subGroupBy == 'client'){
                    $timeEntries = $timeEntries->groupBy('projectID')->transform(function($item, $key){return $item->groupBy('clientID');});
                }
                if($subGroupBy == 'user'){
                    $timeEntries = $timeEntries->groupBy('projectID')->transform(function($item, $key){return $item->groupBy('userID');});
                }
            }else{
                $timeEntries = $timeEntries->groupBy('projectID');
            }
        }
        if ($groupBy == 'user') {
            if ($subGroup == 'true') {
                if ($subGroupBy == 'client') {
                    $timeEntries = $timeEntries->groupBy('userID')->transform(function($item, $key){return $item->groupBy('clientID');});
                }
                if ($subGroupBy == 'project') {
                    $timeEntries = $timeEntries->groupBy('userID')->transform(function($item, $key){return $item->groupBy('projectID');});
                }
            }
            $timeEntries = $timeEntries->groupBy('userID');
        }



        return $timeEntries;







    }
}