<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostUpdateScope()
    {
        factory(\App\Projects\Models\Project::class)->create();
        $response = $this->call('POST', '/projects/views/{project}',
            array(
                '_token' => csrf_token(),
                'description' => 'test',
                'clientID' => 'abc123',
                'billableType' => 'byProject',
                'scope' => 'public',
                'billableHourlyType' => 'none',
                'billableRate' => '1000'
            ));

        $this->assertEquals(302, $response->getStatusCode());

        $this->assertDatabaseHas('projects', [
            'scope' => 'public',
        ]);
    }
}