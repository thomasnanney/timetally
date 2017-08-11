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

    public function testCreateWorkspaceNoName(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => '',
                    'description' => 'A description',
                    'ownerID' => '1',
                    'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a Company Name', $data['messages']['name'][0]);
    }



    public function testCreateWorkspaceNoDescription(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                'name' => 'Workspace 1',
                'description' => '',
                'ownerID' => '1',
                'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);

    }

    public function testCreateWorkspaceNoOwnerID() {
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '',
                    'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Owner ID', $data['messages']['ownerID'][0]);
    }

    public function testCreateWorkspaceNoOrganizationID(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '1',
                    'organizaitonID' => ''
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Organization ID', $data['messages']['organizationID'][0]);

    }


    public function testCreateWorkspaceInvalidOwnerID(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => 'abcd',
                    'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('Please enter an Owner ID', $data['messages']['ownerID'][0]);
    }

    public function testCreateWorkspaceInvalidOrganizationID(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '1',
                    'organizaitonID' => 'abcd'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('Please enter an Organization ID', $data['messages']['organizationID'][0]);

    }

    public function testEditWorkspaceNoName(){
        $user = factory(User::class)->make();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $response = $this->call('POST', '/workspaces/edit/'.$workspace->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => '',
                    'description' => 'Description',
                    'ownerID' => '1',
                    'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('workspaces', [
            'id' => $workspace->id,
            'name' => 'Workspace 2'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a Company Name', $data['messages']['name'][0]);
    }


    public function testEditWorkspaceNoDescription(){
        $user = factory(User::class)->make();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $response = $this->call('POST', '/workspaces/edit/'.$workspace->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 2',
                    'description' => '',
                    'ownerID' => '1',
                    'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('workspaces', [
            'id' => $workspace->id,
            'name' => 'Workspace 2'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);

    }

    public function testEditWorkspaceNoOwnerID() {
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/edit',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '',
                    'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Owner ID', $data['messages']['ownerID'][0]);
    }

    public function testEditWorkspaceNoOrganizationID(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/edit',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '1',
                    'organizaitonID' => ''
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Organization ID', $data['messages']['organizationID'][0]);

    }

    public function testEditWorkspaceInvalidOwnerID(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/edit',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => 'abcd',
                    'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('Please enter an Owner ID', $data['messages']['ownerID'][0]);

    }

    public function testEditWorkspaceInvalidOrganizationID(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/edit',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '1',
                    'organizaitonID' => 'abcd'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('Please enter an Organization ID', $data['messages']['organizationID'][0]);

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


    public function testCreateWorkspaceRobustOwnerID() {
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '1111111111111111111111111111111111111111111111111111111111111111111111',
                    'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Owner ID', $data['messages']['ownerID'][0]);
    }

    public function testCreateWorkspaceRobustOrganizationID(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '1',
                    'organizaitonID' => '1111111111111111111111111111111111111111111111111111111111111111111111'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Organization ID', $data['messages']['organizationID'][0]);

    }

    public function testEditWorkspaceRobustOwnerID() {
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/edit',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '1111111111111111111111111111111111111111111111111111111111111111111111',
                    'organizaitonID' => '1'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Owner ID', $data['messages']['ownerID'][0]);
    }

    public function testEditWorkspaceRobustOrganizationID(){
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('POST', '/workspaces/edit',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'name' => 'Workspace 1',
                    'description' => 'Description',
                    'ownerID' => '1',
                    'organizaitonID' => '1111111111111111111111111111111111111111111111111111111111111111111111'
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('workspaces', [
            'name' => 'Workspace 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Organization ID', $data['messages']['organizationID'][0]);

    }
}
