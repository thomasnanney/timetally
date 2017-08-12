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
        $data['reportType'] = 'PDF';

        $report = Report::generateReportData($data);

        $fileName = Report::createPDF($report);

        return response($fileName, 201);
    }

    public function createReportXLS(Request $request)
    {
        $data = $request->input('data');
        $data['reportType'] = 'XLS';

        $report = Report::generateReportData($data);

        $filename = Report::createReportXLS($report);

        return response($filename, 201);
    }

    public function createReportCSV(Request $request)
    {
        $data = $request->input('data');
        $data['reportType'] = 'CSV';

        $report = Report::generateReportData($data);

        $filename = Report::createReportCSV($report);

        return response($filename, 201);
    }

    public function getDownloadReport($fileName){
        return response()->download(storage_path('app/public/'.$fileName))->deleteFileAfterSend(true);
    }

}
