<?php
namespace App\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class Report extends Model
{
    public static function generateReport($data){
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
            if (!is_null($userFilter) && !empty($userFilterFilter)) {
                $timeEntries->whereIn('userID', $userFilter);
            }
        });
        if(is_null($startDate) || is_null($endDate)){
            $startDate = Carbon::parse('Monday this week')->format('y-m-d');
            $endDate = Carbon::parse('now')->format('y-m-d');
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
        $finalBarData = $finalBarData->union($paddedBarData)->values()->all();
        //get pie data
        if ($subGroup) {
            $timeEntries = ['groups' => $timeEntries->groupBy($groupField)->transform(function ($item, $key) use($subGroupField) {
                return [
                    'title' => $key,
                    'totalTime' => $item->sum('time') / 60,
                    'subGroups' => $item->groupBy($subGroupField)->transform(function ($entry, $key) {
                        return [
                            'title' => $key,
                            'totalTime' => ($entry->sum('time') / 60),
                            'entries' => $entry->transform(function ($item, $k) {
                                return ['description' => $item->description, 'time' => ($item->time / 60)];
                            })->toArray()];
                    })->toArray()];
            })->toArray()];
        }else{
            $timeEntries = [
                'totalTime' => ($timeEntries->sum('time') / 60),
                'groups' => $timeEntries->groupBy($groupField)->transform(function($entry, $key){
                    return [
                        'title' => $key,
                        'totalTime' => ($entry->sum('time') / 60),
                        'entries' => $entry->transform(function($item, $k){
                            return ['description' => $item->description, 'time' => ($item->time / 60)];})->toArray()
                    ];
                })->toArray()];
        }
        $report = array_add($timeEntries, 'groupByType', $groupBy);
        $report = array_add($report, 'subGroup', $subGroup);
        $report = array_add($report, 'subGroupType', $subGroupBy);
        $report = array_add($report, 'barData', $finalBarData);
        return $report;
    }

    public function createTimeEntryReport($reportData)
    {
        // set document information
        PDF::SetAuthor('Org Name');
        PDF::SetTitle('Time Entry Report');
        PDF::SetSubject('Employee Hours');

        // set custom header and footer data
        PDF::setHeaderCallback(function($pdf){
            // Set font
            $pdf->SetFont('helvetica', 'B', 20);
            // Title
            $pdf->Cell(0, 10, 'Time Entry Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            //separator line
            $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
            $pdf->Line(10, 12, 200, 12, $style);
        });
        PDF::setFooterCallback(function($pdf){
            // Position at 15 mm from bottom
            $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            // Page number
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 'T', 0, 'C', 0, '', 0, false, 'C', 'C');
        });

        // set header and footer fonts
        PDF::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        PDF::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-10, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

        PDF::setCellPaddings(2,2,2,2);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        PDF::AddPage();
        PDF::Write(0, 'Time Entry Breakdown:');

        $xc = 105;
        $yc = 100;
        $r = 50;

        PDF::SetFillColor(0, 0, 255);
        PDF::PieSector($xc, $yc, $r, 20, 120, 'FD', false, 0, 2);

        PDF::SetFillColor(0, 255, 0);
        PDF::PieSector($xc, $yc, $r, 120, 250, 'FD', false, 0, 2);

        PDF::SetFillColor(255, 0, 0);
        PDF::PieSector($xc, $yc, $r, 250, 20, 'FD', false, 0, 2);

        // write labels
        PDF::SetTextColor(255,255,255);
        PDF::Text(105, 65, 'BLUE');
        PDF::Text(60, 95, 'GREEN');
        PDF::Text(120, 115, 'RED');

        $data = array(
            'data' => $reportData
        );

        PDF::AddPage();
        PDF::SetTextColor(0,0,0);
        // Set some content to print
        $view = view('payrollReport')->with($data); //add $data here to pass to view
        $html = $view->render();

        // Print text using writeHTMLCell()
        PDF::writeHTML($html, true, false, false, false, '');

        // add a page
        /*PDF::AddPage();
        PDF::setPage(2, true);*/



        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //PDF::Output(__DIR__ . '/Time_Entry_Report.pdf', 'F');
        PDF::Output('Time_Entry_Report.pdf', 'I');
    }
}
