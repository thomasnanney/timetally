<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Users\Models\User as User;
use App\Organizations\Models\Organization as Organization;
use App\Workspaces\Models\Workspace as Workspace;

class WorkspaceTest extends TestCase

{

    use DatabaseTransactions;


    public function testWorkspaceIndex()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('GET', '/workspaces/');

        $this->assertEquals(200, $response->getStatusCode());




    }

    /**

     * A basic test example.

     *

     * @return void

     */

    public function testCreateWorkspace()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $organization = factory(Organization::class)->make();

        $response = $this->call('POST', '/workspaces',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'title' => 'Workspace 1',

                    'ownerID' => $user->id,

                    'organizationID' => $organization->id,

                    'description' => 'Description for Workspace 1',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('workspaces', [

            'title' => 'Workspace 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);

    }


    public function testEditWorkspace()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $organization = factory(Organization::class)->make();

        $workspace = factory(Workspace::class)->create();

        $response = $this->call('POST', '/workspaces/edit/'.$workspace->id,

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Workspace 2',

                    'userID' => $user->id,

                    'organizationID' => $organization->id,

                    'description' => 'Description for Workspace 2',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('workspaces', [

            'name' => 'Workspace 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteWorkspace()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $workspace = factory(Workspace::class)->create();

        $organization = factory(Organization::class)->make();

        $response = $this->call('DELETE', '/workspaces/delete/'.$workspace->id,

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteWorkspaceNoId()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('DELETE', '/workspaces/delete/',

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(404, $response->getStatusCode());

        //ToDo: make 404 page
        //shoudl redirect to  a cusotm 404 page
    }

    public function testDeleteWorkspaceInvalidId()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('DELETE', '/workspaces/delete/19023842093854',

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Workspace not found', $data['messages'][0]);
    }

}
