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
    public static function generateReport($data){
        $clientFilter = $data['filters']['client'];
        $projectFilter = $data['filters']['project'];
        $userFilter = $data['filters']['user'];
        $dateRange = $data['filters']['dateRange'];
        $groupBy = $data['groupBy'];
        $subGroup = $data['subGroup'];
        $subGroupBy = $data['subGroupBy'];

        $user = Auth::user();


        $workspace = $user->current_workspace_id;

        $timeEntries = DB::table('timereports')->select('*')->where('workspaceID', $workspace);
        $timeEntries->where(function ($timeEntries) use ($clientFilter, $projectFilter, $userFilter) {
            if (!is_null($clientFilter)) {
                $timeEntries->whereIn('clientID', $clientFilter);
            }
            if (!is_null($projectFilter)) {
                $timeEntries->whereIn('projectID', $projectFilter);
            }
            if (!is_null($userFilter)) {
                $timeEntries->whereIn('userID', $userFilter);
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
                    $timeEntries = ['groups' => $timeEntries->groupBy('clientName')->transform(function($item, $key){
                        return ['totalTime' => $item->sum('time') / 60,
                            'subGroups' => $item->groupBy('projectTitle')->transform(function($entry, $key){
                                return [
                                    'totalTime' => ($entry->sum('time') / 60),
                                    'entries' => [$entry->transform(function($item, $k){
                                        return ['description' => $item->description, 'time' => ($item->time / 60)];
                                    })->toArray()]];
                            })->toArray()];
                    })->toArray()];
                }
                if ($subGroupBy == 'user') {
                    $timeEntries = ['groups' => $timeEntries->groupBy('clientName')->transform(function($item, $key){
                        return ['totalTime' => $item->sum('time') / 60,
                            'subGroups' => $item->groupBy('userName')->transform(function($entry, $key){
                                return [
                                    'totalTime' => ($entry->sum('time') / 60),
                                    'entries' => [$entry->transform(function($item, $k){
                                        return ['description' => $item->description, 'time' => ($item->time / 60)];
                                    })->toArray()]];
                            })->toArray()];
                    })->toArray()];
                }
            }else{
                $timeEntries = ['groups' => $timeEntries->groupBy('clientName')->transform(function($entry, $key){
                    return [
                        'totalTime' => ($entry->sum('time') / 60),
                        'entries' => [$entry->transform(function($item, $k){
                            return ['description' => $item->description, 'time' => ($item->time / 60)];})->toArray()]];
                })->toArray()];
            }
        }
        if ($groupBy == 'project') {
            if($subGroup == 'true'){
                if($subGroupBy == 'client'){
                    $timeEntries = ['groups' => $timeEntries->groupBy('projectTitle')->transform(function($item, $key){
                        return ['totalTime' => $item->sum('time') / 60,
                            'subGroups' => $item->groupBy('clientName')->transform(function($entry, $key){
                                return [
                                    'totalTime' => ($entry->sum('time') / 60),
                                    'entries' => [$entry->transform(function($item, $k){
                                        return ['description' => $item->description, 'time' => ($item->time / 60)];
                                    })->toArray()]];
                            })->toArray()];
                    })->toArray()];
                }
                if($subGroupBy == 'user'){
                    $timeEntries = ['groups' => $timeEntries->groupBy('projectTitle')->transform(function($item, $key){
                        return ['totalTime' => $item->sum('time') / 60,
                            'subGroups' => $item->groupBy('userName')->transform(function($entry, $key){
                                return [
                                    'totalTime' => ($entry->sum('time') / 60),
                                    'entries' => [$entry->transform(function($item, $k){
                                        return ['description' => $item->description, 'time' => ($item->time / 60)];
                                    })->toArray()]];
                            })->toArray()];
                    })->toArray()];
                }
            }else{
                $timeEntries = ['groups' => $timeEntries->groupBy('projectTitle')->transform(function($entry, $key){
                    return [
                        'totalTime' => ($entry->sum('time') / 60),
                        'entries' => [$entry->transform(function($item, $k){
                            return ['description' => $item->description, 'time' => ($item->time / 60)];})->toArray()]];
                })];
            }
        }
        if ($groupBy == 'user') {
            if ($subGroup == 'true') {
                if ($subGroupBy == 'client') {
                    $timeEntries = ['groups' => $timeEntries->groupBy('userName')->transform(function($item, $key){
                        return ['totalTime' => $item->sum('time') / 60,
                            'subGroups' => $item->groupBy('clientName')->transform(function($entry, $key){
                            return [
                            'totalTime' => ($entry->sum('time') / 60),
                            'entries' => [$entry->transform(function($item, $k){
                                return ['description' => $item->description, 'time' => ($item->time / 60)];
                            })->toArray()]];
                        })->toArray()];
                    })->toArray()];
                }
                if ($subGroupBy == 'project') {
                    $timeEntries = ['groups' => $timeEntries->groupBy('userName')->transform(function($item, $key){
                        return ['totalTime' => $item->sum('time') / 60,
                            'subGroups' => $item->groupBy('projectTitle')->transform(function($entry, $key){
                                return [
                                    'totalTime' => ($entry->sum('time') / 60),
                                    'entries' => [$entry->transform(function($item, $k){
                                        return ['description' => $item->description, 'time' => ($item->time / 60)];
                                    })->toArray()]];
                            })->toArray()];
                    })->toArray()];
                }
            }else{
            $timeEntries = ['groups' => $timeEntries->groupBy('userName')->transform(function($entry, $key){
                return [
                'totalTime' => ($entry->sum('time') / 60),
                'entries' => [$entry->transform(function($item, $k){
                    return ['description' => $item->description, 'time' => ($item->time / 60)];})->toArray()]];
            })->toArray()];
            }
        }

        $report = array_add($timeEntries, 'groupByType', $groupBy);
        $report = array_add($report, 'subGroupBy', $subGroup);
        $report = array_add($report, 'subGroupByType', $subGroupBy);

        return $report;







    }
}