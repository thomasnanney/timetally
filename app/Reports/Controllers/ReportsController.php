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
        /*$shop = array(
            array("title"=>"rose", "price"=>1.25 , "number"=>15),
            array("title"=>"daisy", "price"=>0.75 , "number"=>25),
            array("title"=>"orchid", "price"=>1.15 , "number"=>7)
        );*/

        //$groupby = $request->input('data');
        $subgroup = false;
        //if($groupby['subGroup'] == "false") {
        if(!$subgroup) {
            $data = array(
                //'groupByType' => 'client',  // client/project/user,
                //'subGroup' => 'false',       // true/false,
                //'subGroupType' => 'null',   // null/client/project/user,
                //'groups' => [
                    'client1' => [
                        'title' => 'Client 1',
                        'totalTime' => '20',
                        'entries' => [
                            array(
                                'projectid' => '1',
                                'userid' => '1',
                                'userTime' => '5',
                            ),
                            array(
                                'projectid' => '2',
                                'userid' => '2',
                                'userTime' => '5',
                            ),
                            array(
                                'projectid' => '3',
                                'userid' => '3',
                                'userTime' => '10',
                            )
                        ],
                    ],
                    'client2' => [
                        'title' => 'Client 2',
                        'totalTime' => '27',
                        'entries' => [
                            array(
                                'projectid' => '1',
                                'userid' => '1',
                                'userTime' => '5',
                            ),
                            array(
                                'projectid' => '2',
                                'userid' => '2',
                                'userTime' => '10',
                            ),
                            array(
                                'projectid' => '3',
                                'userid' => '3',
                                'userTime' => '12',
                            )
                        ],
                    ],
                    'client3' => [
                        'title' => 'Client 3',
                        'totalTime' => '50',
                        'entries' => [
                            array(
                                'projectid' => '1',
                                'userid' => '1',
                                'userTime' => '15',
                            ),
                            array(
                                'projectid' => '2',
                                'userid' => '2',
                                'userTime' => '15',
                            ),
                            array(
                                'projectid' => '3',
                                'userid' => '3',
                                'userTime' => '20',
                            )
                        ],
                    ]
                //]
            );
        } else {
            $data = array(
                //'groupByType' => 'project',  // client/project/user,
                //'subGroup' => 'true',       // true/false,
                //'subGroupType' => 'null',   // null/client/project/user,
                'groups' => [
                    'project' => [
                        'title' => 'someName',
                        'totalTime' => 'totalTime for group',
                        'subgroups' => [
                            'subGroup1' => [
                                'title' => 'someName',
                                'totalTime' => 'totalTime for subGroup',
                                'entries' => [
                                    array(
                                        'projectID' => '',
                                        'userID' => '',
                                        'startTime' => '',
                                        'endTime' => '',
                                        'description' => '',
                                        'billable' => ''
                                    ),
                                    array(
                                        'projectID' => '',
                                        'userID' => '',
                                        'startTime' => '',
                                        'endTime' => '',
                                        'description' => '',
                                        'billable' => ''
                                    ),
                                    array(
                                        'projectID' => '',
                                        'userID' => '',
                                        'startTime' => '',
                                        'endTime' => '',
                                        'description' => '',
                                        'billable' => ''
                                    )
                                ]
                            ]
                        ]
                    ]
                ]
            );
        }

        //$shop = $request->input('data');

        $report = new Report;
        $report->createPayrollReport($data);
    }
}
