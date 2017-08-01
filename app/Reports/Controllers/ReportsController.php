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
        /*$data = $request->input('data');*/
        /*$subgroup = false;
        if(!$subgroup) {
            $data = array(
                'subGroup' => false,       // true/false,
                'totalTime' => '159',
                'groups' => [
                    'client1' => [
                        'title' => 'Client 1',
                        'totalTime' => '20',
                        'entries' => [
                            array(
                                'description' => 'test',
                                'time' => '1',
                            ),
                            array(
                                'description' => 'test',
                                'time' => '1',
                            ),
                            array(
                                'description' => 'test',
                                'time' => '1',
                            )
                        ],
                    ],
                    'client2' => [
                        'title' => 'Client 2',
                        'totalTime' => '27',
                        'entries' => [
                            array(
                                'description' => 'test',
                                'time' => '1',
                            ),
                            array(
                                'description' => 'test',
                                'time' => '1',
                            ),
                            array(
                                'description' => 'test',
                                'time' => '1',
                            )
                        ],
                    ],
                    'client3' => [
                        'title' => 'Client 3',
                        'totalTime' => '50',
                        'entries' => [
                            array(
                                'description' => 'test',
                                'time' => '1',
                            ),
                            array(
                                'description' => 'test',
                                'time' => '1',
                            ),
                            array(
                                'description' => 'test',
                                'time' => '1',
                            )
                        ],
                    ]
                ]
            );
        } else {
            $data = array(
                'groups' => [
                    'Clients' => [
                        'title' => 'Clients',
                        'totalTime' => 'totalTime for subGroup',
                        'subGroups' => [ //was detail
                            'client1' => [
                                'title' => 'Client 1',
                                'totalTime' => '20',
                                'entries' => [
                                    array(
                                        'description' => 'test',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '10',
                                    )
                                ],
                            ],
                            'client2' => [
                                'title' => 'Client 2',
                                'totalTime' => '27',
                                'entries' => [
                                    array(
                                        'description' => 'test',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '10',
                                    )
                                ],
                            ],
                            'client3' => [
                                'title' => 'Client 3',
                                'totalTime' => '50',
                                'entries' => [
                                    array(
                                        'description' => 'test',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '10',
                                    )
                                ],
                            ]
                        ]
                    ],
                    'Users' => [
                        'title' => 'Users',
                        'totalTime' => 'totalTime for subGroup',
                        'subGroups' => [ //was detail
                            'user1' => [
                                'title' => 'User 1',
                                'totalTime' => '20',
                                'entries' => [
                                    array(
                                        'description' => 'test',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '10',
                                    )
                                ],
                            ],
                            'user2' => [
                                'title' => 'User 2',
                                'totalTime' => '27',
                                'entries' => [
                                    array(
                                        'description' => 'test',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '10',
                                    )
                                ],
                            ],
                            'user3' => [
                                'title' => 'User 3',
                                'totalTime' => '50',
                                'entries' => [
                                    array(
                                        'description' => 'test',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '5',
                                    ),
                                    array(
                                        'description' => '1',
                                        'time' => '10',
                                    )
                                ],
                            ]
                        ]
                    ]
                ],
                'subGroup' => 'true',       // true/false,
                'subGroupType' => 'client',
                'title' => 'Projects',
                'totalTime' => '100',
            );
        }*/

        //$data = $request->input('data');
        /*$data = json_decode('{
              "data": {
                "startDate": "2017-07-24T17:46:36.143Z",
                "endDate": "2017-07-30T17:46:36.143Z",
                "filters": {
                  "users": [
                    "0",
                    "2"
                  ],
                  "clients": [

                  ],
                  "projects": [

                  ]
                },
                "groupBy": "client",
                "subGroup": false,
                "subGroupBy": ""
              }
            }', TRUE);*/

        //$report = new Report();
        $data = $request->input('data');
        $report = Report::generateReport($data);

        $report->createTimeEntryReport($data);
    }

    public function getReport(Request $request){
        $data = $request->input('data');

        $report = Report::generateReportData($data);

        return response()->json(['data' => $report]);


    }
}
