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
        $subgroup = true;
        if(!$subgroup) {
            $data = array(
                'subGroup' => 'false',       // true/false,
                'groups' => [
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
                ]
            );
        } else {
            $data = array(
                'subGroup' => 'true',       // true/false,
                'title' => 'Projects',
                'totalTime' => '100',
                'groups' => [
                    'subGroup1' => [
                        'title' => 'Clients',
                        'totalTime' => 'totalTime for subGroup',
                        'detail' => [
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
                                        'projectid' => '1',
                                        'userid' => '2',
                                        'userTime' => '5',
                                    ),
                                    array(
                                        'projectid' => '1',
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
                                        'projectid' => '1',
                                        'userid' => '2',
                                        'userTime' => '10',
                                    ),
                                    array(
                                        'projectid' => '1',
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
                                        'projectid' => '1',
                                        'userid' => '2',
                                        'userTime' => '15',
                                    ),
                                    array(
                                        'projectid' => '1',
                                        'userid' => '3',
                                        'userTime' => '20',
                                    )
                                ],
                            ]
                        ]
                    ],
                    'subgroup2' => [
                        'title' => 'Users',
                        'totalTime' => 'totalTime for subGroup',
                        'detail' => [
                            'user1' => [
                                'title' => 'User 1',
                                'totalTime' => '20',
                                'entries' => [
                                    array(
                                        'projectid' => '2',
                                        'userid' => '1',
                                        'userTime' => '5',
                                    ),
                                    array(
                                        'projectid' => '2',
                                        'userid' => '2',
                                        'userTime' => '5',
                                    ),
                                    array(
                                        'projectid' => '2',
                                        'userid' => '3',
                                        'userTime' => '10',
                                    )
                                ],
                            ],
                            'user2' => [
                                'title' => 'User 2',
                                'totalTime' => '27',
                                'entries' => [
                                    array(
                                        'projectid' => '2',
                                        'userid' => '1',
                                        'userTime' => '5',
                                    ),
                                    array(
                                        'projectid' => '2',
                                        'userid' => '2',
                                        'userTime' => '10',
                                    ),
                                    array(
                                        'projectid' => '2',
                                        'userid' => '3',
                                        'userTime' => '12',
                                    )
                                ],
                            ],
                            'user3' => [
                                'title' => 'User 3',
                                'totalTime' => '50',
                                'entries' => [
                                    array(
                                        'projectid' => '2',
                                        'userid' => '1',
                                        'userTime' => '15',
                                    ),
                                    array(
                                        'projectid' => '2',
                                        'userid' => '2',
                                        'userTime' => '15',
                                    ),
                                    array(
                                        'projectid' => '2',
                                        'userid' => '3',
                                        'userTime' => '20',
                                    )
                                ],
                            ]
                        ]
                    ]
                ]
            );
        }

        $report = new Report;
        $report->createPayrollReport($data);
    }
}
