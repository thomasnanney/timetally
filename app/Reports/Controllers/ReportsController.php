<?php

namespace App\Reports\Controllers;

use Illuminate\Http\Request;
use App\Reports\Models\Report;
use App\Core\Controllers\Controller;
use PDF;

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

    public function createPayrollReport()
    {
        $shop = array(
            array("title"=>"rose", "price"=>1.25 , "number"=>15),
            array("title"=>"daisy", "price"=>0.75 , "number"=>25),
            array("title"=>"orchid", "price"=>1.15 , "number"=>7)
        );

        $report = new Report;
        $report->createPayrollReport($shop);
    }
}
