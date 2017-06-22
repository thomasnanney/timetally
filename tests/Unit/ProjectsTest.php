<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Users\Models\User as User;
use App\Clients\Models\Client as Client;

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
        $project = factory(\App\Projects\Models\Project::class)->create();
        $response = $this->call('POST', '/projects/edit/'.$project->id,
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

    public function testPostUpdateBillableType()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $project = factory(\App\Projects\Models\Project::class)->create([
            'clientID' => $client->id,
        ]);
        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'projectTitle' => $project->title,
                    'description' => 'test',
                    'clientID' => $project->clientID,
                    'billableType' => 'byProject',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => $project->startDate,
                    'endDate' => $project->endDate,
                    'projectedTime' => $project->projectedTime,
                    'projectedRevenue' => $project->projectedRevenue
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'billableType' => 'byProject',
        ]);
    }
}