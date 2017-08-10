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
    }

    public function getReport(Request $request, $type){

        $data = $request->input('data');
        $data['reportType'] = $type;

        $timezone = $request->get('timezone');

        $report = Report::generateReportData($data, $timezone);

        return response()->json($report);

    }

    public function createReportPDF(Request $request)
    {
        $data = $request->input('data');

        $report = Report::generateReportData($data);

        Report::createPDF($report);
    }

    public function createReportXLS(Request $request)
    {
        $data = $request->input('data');

        $report = Report::generateReportData($data);

        Report::createReportXLS($report);
    }

    public function createReportCSV(Request $request)
    {
        $data = $request->input('data');

        $report = Report::generateReportData($data);

        Report::createReportCSV($report);
    }

}
