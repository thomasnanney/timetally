<?php

namespace App\Reports\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use PDF;
use App\Reports\Models\Report;

class ReportsController extends Controller
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
        return view('reports');
        //return view('payrollReport');
    }

    public function downloadCSV()
    {
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=Time_Entry_Report.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $list = TimeEntries::all()->toArray();

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function() use ($list)
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function createTimeEntryReportPDF(Request $request)
    {
        $data = $request->input('data');
        $report = Report::generateReport($data);
        $pdf = Report::createTimeEntryReport($report);

        return response()->json(['data' => $pdf]);
    }

    public function getReport(Request $request){
        $data = $request->input('data');

        $report = Report::generateReportData($data);

        return response()->json(['data' => $report]);


    }
}
