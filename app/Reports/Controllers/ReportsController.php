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

    public function getReport(Request $request){
        $data = $request->input('data');

        $report = Report::generateReportData($data);

        return response()->json(['data' => $report]);
    }

    public function createTimeEntryReportPDF(Request $request)
    {
        $data = $request->input('data');

        $report = Report::generateReport($data);

        $pdf = Report::createTimeEntryReportPDF($report);

        return response()->json(['data' => $pdf]);
    }

    public function createTimeEntryReportXLS(Request $request) {
        $data = $request->input('data');

        $report = Report::generateReport($data);

        $xls = Report::createTimeEntryReportXLS($report);

        return response()->json(['data' => $xls]);
    }

    public function createTimeEntryReportCSV(Request $request) {
        $data = $request->input('data');

        $report = Report::generateReport($data);

        $csv = Report::createTimeEntryReportCSV($report);

        return response()->json(['data' => $csv]);
    }

}
