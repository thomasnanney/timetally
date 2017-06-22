<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Clients\Models\Client as Client;
use App\Projects\Models\Project as Project;
use App\Workspaces\Models\Workspace as Workspace;
use App\Users\Models\User as User;

class WorkspaceTest extends TestCase

{

    use DatabaseTransactions;


    public function testProjectIndex()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('GET', '/projects/');

        $this->assertEquals(200, $response->getStatusCode());




    }

    /**

     * A basic test example.

     *

     * @return void

     */

    public function testCreateProject()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $client = factory(Client::class)->make();

        $workspace = factory(Workspace::class)->make();

        $response = $this->call('POST', '/projects',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Project 1',

                    'clientID' => $client->id,

                    'workspaceID' => $workspace->id,

                    'description' => 'Description for Project 1',

                    'projectedRevenue' => 10.00,

                    'projectedTime' => 10,

                    'billableType' => 'hourly',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('projects', [

            'title' => 'Project'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);

    }


    public function testEditProject()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $client = factory(Client::class)->make();

        $workspace = factory(Workspace::class)->make();

        $response = $this->call('POST', '/workspaces/edit/'.$project->id,

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Project 2',

                    'clientID' => $client->id,

                    'workspaceID' => $workspace->id,

                    'description' => 'Description for Project 2',

                    'projectedRevenue' => 20.00,

                    'projectedTime' => 20,

                    'billableType' => 'projection',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('projects', [

            'name' => 'Project 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteProject()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $project = factory(Project::class)->make();

        $response = $this->call('DELETE', '/workspaces/delete/'.$project->id,

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteProjectNoId()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('DELETE', '/projects/delete/',

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(404, $response->getStatusCode());

        //ToDo: make 404 page
        //shoudl redirect to  a cusotm 404 page
    }

    public function testDeleteProjectInvalidId()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('DELETE', '/projects/delete/19023842093854',

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Project not found', $data['messages'][0]);
    }

}
