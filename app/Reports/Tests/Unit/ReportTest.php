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

    /**
     * Test to create a new project
     *
     * @return void
     */
    public function testDownloadPDFNoSubGroup()
    {
        $response = $this->call('GET', '/reports/getReportPDF',
            array(
                '_token' => csrf_token(),
                'data' => array(
                    'startDate' => '2017-07-24T17:46:36.143Z',
                    'endDate' => '2017-07-30T17:46:36.143Z',
                    'filters' => array(
                        'users' => [
                            '1',
                            '2'
                        ],
                        'clients' => [

                        ],
                        'projects' => [

                        ]
                    ),
                    'groupBy' => 'client',
                    'subGroup' => false,
                    'subGroupBy' => ''
                )
            ));

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testDownloadPDFWithSubGroup()
    {
        $response = $this->call('GET', '/reports/getReportPDF',
            array(
                '_token' => csrf_token(),
                'data' => array(
                    'startDate' => '2017-07-24T17:46:36.143Z',
                    'endDate' => '2017-07-30T17:46:36.143Z',
                    'filters' => array(
                        'users' => [
                            '1',
                            '2'
                        ],
                        'clients' => [

                        ],
                        'projects' => [

                        ]
                    ),
                    'groupBy' => 'users',
                    'subGroup' => true,
                    'subGroupBy' => 'client'
                )
            ));

        $this->assertEquals(302, $response->getStatusCode());
    }

}


