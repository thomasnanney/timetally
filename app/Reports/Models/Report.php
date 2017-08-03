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
use App\Users\Models\User;


class Report
{
    public static function generateReportData($data){
        $clientFilter = $data['filters']['clients'];
        $projectFilter = $data['filters']['projects'];
        $userFilter = $data['filters']['users'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $groupBy = $data['groupBy'];
        $subGroup = $data['subGroup'];
        $subGroupBy = $data['subGroupBy'];

        //figure out keys to filter and order by
        $groupField = '';
        $groupKey = '';
        switch($groupBy){
            case 'client':
                $groupField = 'clientName';
                $groupKey = 'clientID';
                break;
            case 'user':
                $groupField = 'userName';
                $groupKey = 'userID';
                break;
            case 'project':
                $groupField = 'projectTitle';
                $groupKey = 'projectID';
                break;
        }

        if($subGroup){
            $subGroupField = '';
            $subGroupKey = '';
            switch($subGroupBy){
                case 'client':
                    $subGroupField = 'clientName';
                    $subGroupKey = 'clientID';
                    break;
                case 'user':
                    $subGroupField = 'userName';
                    $subGroupKey = 'userID';
                    break;
                case 'project':
                    $subGroupField = 'projectTitle';
                    $subGroupKey = 'projectID';
                    break;
            }
        }

//        var_dump(!is_null($userFilter));
//        var_dump(!empty($userFilter));

        //Retrieve entries from DB
        $user = Auth::user();
        $workspace = $user->current_workspace_id;

        $timeEntries = DB::table('timereports')->select('*')->where('workspaceID', $workspace);
        $timeEntries->where(function ($timeEntries) use ($clientFilter, $projectFilter, $userFilter) {
            if (!is_null($clientFilter) && !empty($clientFilter)) {
                $timeEntries->whereIn('clientID', $clientFilter);
            }
            if (!is_null($projectFilter) && !empty($projectFilter)) {
                $timeEntries->whereIn('projectID', $projectFilter);
            }
            if (!is_null($userFilter) && !empty($userFilter)) {
                $timeEntries->whereIn('userID', $userFilter);
            }
        });

        if(is_null($startDate) || is_null($endDate)){
            $startDate = Carbon::parse('Monday this week')->format('y-m-d');
            $endDate = Carbon::parse('Sunday this week')->format('y-m-d');
            $timeEntries->whereBetween('startTime', [$startDate, $endDate]);
        }else{
            $startDate = Carbon::parse($startDate)->format('Y-m-d');
            $endDate = Carbon::parse($endDate)->format('Y-m-d');
            $timeEntries->whereBetween('startTime', [$startDate, $endDate]);
        }
        if($subGroup){
            $timeEntries = $timeEntries->orderBy($groupField, 'asc')->orderBy($subGroupField, 'asc')->get();
        }else{
            $timeEntries = $timeEntries->orderBy($groupField, 'asc')->get();
        }

        //clone collection to prepare bar adn pie data as well
        $barData = clone $timeEntries;
        $pieData = clone $timeEntries;

        //get bar data
        $finalBarData = $barData->groupBy(function($entry, $key){
            return date('Y-m-d', strtotime($entry->startTime));
        })->transform(function($entry){
            return [
                'name'=> date('Y-m-d', strtotime($entry[0]->startTime)),
                'value' => $entry->sum('time')/60
            ];
        });

        $paddedBarData = collect();
        $chartDate = date('Y-m-d', strtotime('+1 days', strtotime($startDate)));
        while(strtotime($chartDate) <= strtotime($endDate)){
            $data = [
                'name' => $chartDate,
                'value' => 0
            ];
            $paddedBarData->put($chartDate, $data);
            $chartDate = date('Y-m-d', strtotime('+1 days', strtotime($chartDate )));
        }

        $finalBarData = $finalBarData->union($paddedBarData)->sortBy(function($entry, $key){
            return $key;
        })->values();

        //get pie data
        //get bar data
        $finalPieData = $pieData->groupBy('clientID')->transform(function($entry){
            return [
                'name'=> $entry[0]->clientName,
                'value' => $entry->sum('time')/60
            ];
        })->values();


        if ($subGroup) {
            $timeEntries = [
                'totalTime' => ($timeEntries->sum('time')/60),
                'groups' => $timeEntries->groupBy($groupField)->transform(function ($item, $key) use($subGroupField) {
                return [
                    'title' => $key,
                    'totalTime' => $item->sum('time') / 60,
                    'subGroups' => $item->groupBy($subGroupField)->transform(function ($entry, $key) {
                        return [
                            'title' => $key,
                            'totalTime' => ($entry->sum('time') / 60),
                            'entries' => $entry->transform(function ($item, $k) {
                                return [
                                    'date' => date('Y-m-d', strtotime($item->startTime)),
                                    'description' => $item->description,
                                    'time' => ($item->time / 60)];
                            })->sortBy('date')->values()->toArray()
                        ];
                    })->toArray()];
            })->toArray()];
        }else{
            $timeEntries = [
                'totalTime' => ($timeEntries->sum('time') / 60),
                'groups' => $timeEntries->groupBy($groupField)->transform(function($entry, $key){
                return [
                    'title' => $key,
                    'totalTime' => ($entry->sum('time') / 60),
                    'entries' => $entry->transform(function($item){
                        return [
                            'date' => date('Y-m-d', strtotime($item->startTime)),
                            'description' => $item->description,
                            'time' => ($item->time / 60)];
                    })->sortBy('date')->values()->toArray()
                ];
            })->toArray()];
        }

        $report = array_add($timeEntries, 'groupByType', $groupBy);
        $report = array_add($report, 'subGroup', $subGroup);
        $report = array_add($report, 'subGroupType', $subGroupBy);
        $report = array_add($report, 'barData', $finalBarData);
        $report = array_add($report, 'pieData', $finalPieData);

        return $report;

    }
}