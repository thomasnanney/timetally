<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Users\Models\User as User;

class ReportsTest extends TestCase
{
    use DatabaseTransactions;

    public function testDownloadPDFNoSubGroup()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->call('POST', '/reports/getReportPDF',
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
                    'subGroupBy' => '',
                    'reportType' => 'timeEntry'
                )
            ));

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testDownloadPDFWithSubGroup()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->call('POST', '/reports/getReportPDF',
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
                    'groupBy' => 'user',
                    'subGroup' => true,
                    'subGroupBy' => 'client',
                    'reportType' => 'timeEntry'
                )
            ));

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testDownloadXLSNoSubGroup()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->call('POST', '/reports/getReportXLS',
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
                    'subGroupBy' => '',
                    'reportType' => 'timeEntry'
                )
            ));

        $this->assertEquals(201, $response->getStatusCode());
    }

}


