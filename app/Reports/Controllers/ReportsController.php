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

    public function createReportPDF(Request $request)
    {
        //$data = $request->input('data');
        $data = [
            "startDate" => "2017-07-24T17:46:36.143Z",
            "endDate" => "2017-07-30T17:46:36.143Z",
            "filters" => [
                "users" => [
                    "1",
                    "2"
                ],
                "clients" => [
                ],
                "projects" => [
                ]
            ],
            "groupBy" => "user",
            "subGroup" => false,
            "subGroupBy" => "client",
            "reportType" => "timeEntry"
        ];

        $report = Report::generateReportData($data);

        /*ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        var_dump($report);*/
        $pdf = Report::createPDF($report);

        return response()->json(['data' => $pdf]);
    }

    public function createReportXLS(Request $request) {
        //$data = $request->input('data');
        $data = [
            "startDate" => "2017-07-24T17:46:36.143Z",
            "endDate" => "2017-07-30T17:46:36.143Z",
            "filters" => [
                "users" => [
                    "1",
                    "2"
                ],
                "clients" => [
                ],
                "projects" => [
                ]
            ],
            "groupBy" => "user",
            "subGroup" => false,
            "subGroupBy" => "client",
            "reportType" => "timeEntry"
        ];

        $report = Report::generateReportData($data);

        $xls = Report::createReportXLS($report);

        return response()->json(['data' => $xls]);
    }

    public function createReportCSV(Request $request) {
        //$data = $request->input('data');
        $data = [
            "startDate" => "2017-07-24T17:46:36.143Z",
            "endDate" => "2017-07-30T17:46:36.143Z",
            "filters" => [
                "users" => [
                    "1",
                    "2"
                ],
                "clients" => [
                ],
                "projects" => [
                ]
            ],
            "groupBy" => "user",
            "subGroup" => false,
            "subGroupBy" => "client",
            "reportType" => "timeEntry"
        ];
        $report = Report::generateReportData($data);

        $csv = Report::createReportCSV($report);

        return response()->json(['data' => $csv]);
    }

}
