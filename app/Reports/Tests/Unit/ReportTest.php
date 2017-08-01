<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Clients\Models\Client as Client;
use App\Projects\Models\Project as Project;
use App\Workspaces\Models\Workspace as Workspace;
use App\Users\Models\User as User;

class ReportsTest extends TestCase
{
    use DatabaseTransactions;

    /*public function testProjectIndex()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('GET', '/projects/');
        $this->assertEquals(200, $response->getStatusCode());
    }*/

    /**
     * Test to create a new project
     *
     * @return void
     */
    public function testDownloadPDFNoSubGroup()
    {
        /*$user = factory(User::class)->create();
        $this->be($user);*/

        $response = $this->call('GET', '/reports/timeEntryReportPDF',
            array(
                '_token' => csrf_token(),
                'data' => array(
                    'subGroup' => 'false',
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
                )
            ));

        //$this->assertFileExists(__DIR__ . '/Time_Entry_Report.pdf');
        $this->assertEquals(200, $response->getStatusCode());
        /*$this->assertDatabaseHas('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);*/
    }

    /*public function testDownloadPDFSubGroup()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->call('GET', '/reports/timeEntryReportPDF',
            array(
                '_token' => csrf_token(),
                'data' => array(
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
                )
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }*/

}


