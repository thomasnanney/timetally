<?php
namespace App\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use DateInterval;
use \SVGGraph;
use Excel;
use PDF;

class Report extends Model
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
        $reportType = $data['reportType'];

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
//            var_dump(Carbon::parse($startDate)->format('Y-m-d'));
            $endDate = Carbon::parse($endDate)->format('Y-m-d');
            $timeEntries->whereBetween('startTime', [$startDate, $endDate]);
        }
        if($subGroup){
            $timeEntries = $timeEntries->orderBy($groupField, 'asc')->orderBy($subGroupField, 'asc')->get();
        }else{
            $timeEntries = $timeEntries->orderBy($groupField, 'asc')->get();
        }

//        var_dump($timeEntries);

//        //adjust all time entries to users local time zone so they are properly grouped
//        $timeEntries = $timeEntries->map(function($entry) use($timezone) {
//            $date = new DateTime($entry->startTime);
//            $date->setTimezone(new DateTimeZone($timezone));
//            return $date->format('Y-m-d');
//        });

        //clone collection to prepare bar adn pie data as well
        $barData = clone $timeEntries;
        $pieData = clone $timeEntries;

        //get bar data
        $finalBarData = $barData->groupBy(function($entry){
            $date = new DateTime($entry->startTime);
//            $date->setTimezone(new DateTimeZone($timezone));
            return $date->format('m-d-Y');
        })->transform(function($entry){
            $date = new DateTime($entry[0]->startTime);
//            $date->setTimezone(new DateTimeZone($timezone));
            return [
                'name'=> $date->format('m-d-Y'),
                'value' => round(($entry->sum('time')/60),2)
            ];
        });

        $paddedBarData = collect();
        $chartDate = new DateTime($startDate);
//        $chartDate->setTimezone(new DateTimeZone($timezone));
        $endDate = new DateTime($endDate);
//        $endDate->setTimezone(new DateTimeZone(($timezone)));
        while($chartDate <= $endDate){
            $data = [
                'name' => $chartDate->format('m-d-Y'),
                'value' => 0
            ];
            $paddedBarData->put($chartDate->format('m-d-Y'), $data);
            $chartDate->add(new DateInterval('P1D'));
        }

        $finalBarData = $finalBarData->union($paddedBarData)->sortBy(function($entry, $key){
            return $key;
        })->values();

        //get pie data
        //get bar data
        $finalPieData = $pieData->groupBy('clientID')->transform(function($entry){
            return [
                    'name'=> $entry[0]->clientName,
                    'value' => round(($entry->sum('time')/60), 2)
                ];
        })->values();


        if ($subGroup) {
            $timeEntries = [
                'totalTime' => round(($timeEntries->sum('time')/60), 2),
                'groups' => $timeEntries->groupBy($groupField)->transform(function ($item, $key) use($subGroupField) {
                return [
                    'title' => $key,
                    'totalTime' => round(($item->sum('time') / 60), 2),
                    'subGroups' => $item->groupBy($subGroupField)->transform(function ($entry, $key) {
                        return [
                            'title' => $key,
                            'totalTime' => round(($entry->sum('time') / 60), 2),
                            'entries' => $entry->transform(function ($item, $k) {
                                return [
                                    'date' => date('Y-m-d', strtotime($item->startTime)),
                                    'description' => $item->description,
                                    'time' => round(($item->time / 60), 2)];
                            })->sortBy('date')->values()->toArray()
                        ];
                    })->toArray()];
            })->toArray()];
        }else{
            $timeEntries = [
                'totalTime' => round(($timeEntries->sum('time') / 60),2),
                'groups' => $timeEntries->groupBy($groupField)->transform(function($entry, $key){
                return [
                    'title' => $key,
                    'totalTime' => round(($entry->sum('time') / 60), 2),
                    'entries' => $entry->transform(function($item){
                        return [
                            'date' => date('Y-m-d', strtotime($item->startTime)),
                            'description' => $item->description,
                            'time' => round(($item->time / 60), 2)];
                    })->sortBy('date')->values()->toArray()
                ];
            })->toArray()];
        }

        $report = array_add($timeEntries, 'groupByType', $groupBy);
        $report = array_add($report, 'subGroup', $subGroup);
        $report = array_add($report, 'subGroupType', $subGroupBy);
        $report = array_add($report, 'barData', $finalBarData);
        $report = array_add($report, 'pieData', $finalPieData);
        $report = array_add($report, 'reportType', $reportType);

        return $report;

    }

    public static function createPDF($reportData)
    {

        $titles = array();
        switch($reportData['reportType']) {
            case 'timeEntry':
                $titles = [
                    'reportTitle' => 'Time Entry Report',
                    'barReportTitle' => 'Hours By Day',
                    'barAxisTitles' => [
                        'y' => 'Number of Hours',
                        'x' => 'Date'
                    ],
                    'pieReportTitle' => 'Hours By Employee'
                ];
                break;
            case 'billableRatePerEmployee':
                $titles = [
                    'reportTitle' => 'Billable Rate Per Employee Report',
                    'barReportTitle' => 'Cost by Day',
                    'barAxisTitles' => [
                        'y' => 'Cost',
                        'x' => 'Date'
                    ],
                    'pieReportTitle' => ''
                ];
                break;
            default:
                $titles = [
                    'reportTitle' => 'No Report Type Specified',
                    'barReportTitle' => '',
                    'barAxisTitles' => [
                        'y' => '',
                        'x' => ''
                    ],
                    'pieReportTitle' => ''
                ];
        }

        // set document information
        PDF::SetAuthor('TimeKeeper');
        PDF::SetTitle($titles['reportTitle']);

        // set custom header and footer data
        PDF::setHeaderCallback(function ($pdf) use($titles) {
            // Set font
            $pdf->SetFont('helvetica', 'B', 20);
            // Title
            $pdf->Cell(0, 10, $titles['reportTitle'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
            //separator line
            $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
            $pdf->Line(10, 12, 200, 12, $style);
        });
        PDF::setFooterCallback(function ($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            // Page number
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 'T', 0, 'C', 0, '', 0, false, 'C', 'C');
        });

        // set header and footer fonts
        PDF::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        PDF::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP - 10, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

        PDF::setCellPaddings(2, 2, 2, 2);

        // ----------------------------------------------------------

        /*
         * Create Bar Graph
         */
        PDF::AddPage();
        $barOutput = Report::createBarGraph($reportData['barData'], $titles);
        PDF::ImageSVG('@' . $barOutput, $x=6, $y=20, $w='', $h=100, $link='', $align='', $palign='', $border=0, $fitonpage=false);

        /*
         * Create Pie Chart
         */
        $pieOutput = Report::createPieChart($reportData['pieData'], $titles);
        PDF::ImageSVG('@' . $pieOutput, $x=10, $y=140, $w='', $h=100, $link='', $align='', $palign='', $border=0, $fitonpage=false);

        /*
         * Create data table
         */
        $data = array('data' => $reportData);

        PDF::AddPage();
        PDF::setPage(2, true);
        PDF::SetTextColor(0,0,0);
        $view = view('reportPDF')->with($data); //add $data here to pass to view
        $html = $view->render();

        PDF::writeHTML($html, true, false, false, false, '');


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        PDF::Output($titles['reportTitle'].'.pdf', 'D');
    }

    public static function createBarGraph($barData, $titles){
        $bars = array();
        foreach($barData as $values) {
            $bars[$values['name']] = $values['value'];
        }

        $settings = array(
            'graph_title' => $titles['barReportTitle'],
            'graph_title_font_size' => 25,
            'label_v' => $titles['barAxisTitles']['y'],
            'label_h' => $titles['barAxisTitles']['x'],
            'label_font_size' => 20,
            'label_space' => 20
        );
        $graph = new SVGGraph(950, 500, $settings);
        $graph->colours = array('#75a3a3');
        $graph->Values($bars);

        return $graph->Fetch('BarGraph');

    }

    public static function createPieChart($pieData, $titles){
        $slices = array();
        foreach($pieData as $values) {
            $slices[$values['name']] = $values['value'];
        }

        $settings = array(
            'back_colour' => '#eee',
            'stroke_colour' => '#000',
            'back_stroke_width' => 0,
            'back_stroke_colour' => '#eee',
            'pad_right' => 20,
            'pad_left' => 20,
            'link_base' => '/',
            'link_target' => '_top',
            'show_labels' => true,
            'show_label_amount' => true,
            'label_font' => 'Georgia',
            'label_font_size' => '17',
            'label_colour' => '#000',
            'sort' => false,
            'graph_title' => $titles['pieReportTitle'],
            'graph_title_font_size' => 25,
            'label_position' => 0.6,
            'depth' => 20
        );
        $colours = array('#ccf','#699','#93c','#996','#f39','#0f3','#339');

        $graph = new SVGGraph(950, 500, $settings);
        $graph->colours = $colours;
        $graph->Values($slices);

        return $graph->Fetch('Pie3DGraph');

    }

    public static function createReportXLS($reportData){
        $data = array('data' => $reportData);

        Excel::create($reportData['reportType'], function($excel) use($data) {
            $excel->sheet('Detail', function($sheet) use($data) {
                $sheet->loadView('reportXLS', $data);
            });
        })->export('xls');
    }

    public static function createReportCSV($reportData){
        $data = array('data' => $reportData);

        Excel::create($reportData['reportType'], function($excel) use($data) {
            $excel->sheet('Detail', function($sheet) use($data) {
                $sheet->loadView('reportXLS', $data);
            });
        })->export('csv');
    }
}
