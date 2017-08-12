<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Clients\Models\Client as Client;
use App\Projects\Models\Project as Project;
use App\Workspaces\Models\Workspace as Workspace;
use App\Users\Models\User as User;

class ProjectsTest extends TestCase
{
    use DatabaseTransactions;

    //var_dump(json_decode($response->getContent()), true);

    public function testProjectIndex()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('GET', '/projects/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test to create a new project
     *
     * @return void
     */
    public function testCreateProject()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }

    public function testCreateProjectPrivate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 1,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }

    public function testEditProjectPrivate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);


        $projectedRevenue = ($project->projectedRevenue = 20.00 ? 21.00 : 20.00);
        $projectedCost = ($project->projectedCost = 8.00 ? 9.00 : 8.00);
        $projectedTime = ($project->projectedTime = 20 ? 21 : 20);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => $projectedRevenue,
                    'projectedCost' => $projectedCost,
                    'projectedTime' => $projectedTime,
                    'private' => 1,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Project 2',
            'description' => 'Description for Project 2',
            'projectedRevenue' => $projectedRevenue,
            'projectedCost' => $projectedCost,
            'projectedTime' => $projectedTime,
            'private' => 1,
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Project successfully updated', $data['messages']);
    }

    /**
     * Test to create a new project
     * with a missing Title
     *
     * @return void
     */
    public function testCreateProjectMissingTitle()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => null,
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'description' => 'Description for Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Please enter a Project Title', $data['messages']['title']['0']);
    }

    /**
     * Test to create a new project
     * with a missing Client ID
     *
     * @return void
     */
    public function testCreateProjectMissingClientID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => null,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Please enter a Client Name', $data['messages']['clientID']['0']);
    }

    /**
     * Test to create a new project
     * with an invalid Client ID
     *
     * @return void
     */
    public function testCreateProjectInvalidClientID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;

        $test = ($client->id = 72 ? 73 : 72);

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $test,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.exists', $data['messages']['clientID']['0']);
    }

    /**
     * Test to create a new project
     * with a missing Workspace ID
     *
     * @return void
     */
    public function testCreateProjectMissingWorkspaceID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.exists', $data['messages']['workspaceID']['0']);
    }

    /**
     * Test to create a new project
     * with an invalid Workspace ID
     *
     * @return void
     */
    public function testCreateProjectInvalidWorkspaceID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();

        $test = ($workspace->id = 72 ? 73 : 72);
        $user['current_workspace_id'] = $test;

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.exists', $data['messages']['workspaceID']['0']);
    }

    /**
     * Test to create a new project
     * with a missing Start Date
     *
     * @return void
     */
    public function testCreateProjectMissingStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => null,
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Please enter a Start Date', $data['messages']['startDate']['0']);
    }

    /**
     * Test to create a new project
     * with an invalid Start Date
     *
     * @return void
     */
    public function testCreateProjectInvalidStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '05-03-2017',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['startDate']['0']);
    }

    /**
     * Test to create a new project
     * with a missing End Date
     *
     * @return void
     */
    public function testCreateProjectMissingEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => null,
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Please enter an End Date', $data['messages']['endDate']['0']);
    }

    /**
     * Test to create a new project
     * with an invalid End Date
     *
     * @return void
     */
    public function testCreateProjectInvalidEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-05 00:00:00',
                    'endDate' => '05-03-2017',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['endDate']['0']);
    }

    /**
     * Test to create a new project
     * with a missing Projected Time
     *
     * @return void
     */
    public function testCreateProjectMissingProjectedTime()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => null,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Please entered a projected time', $data['messages']['projectedTime']['0']);
    }

    /**
     * Test to create a new project
     * with an invalid Projected Time
     *
     * @return void
     */
    public function testCreateProjectInvalidProjectedTime()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 'test',
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.integer', $data['messages']['projectedTime']['0']);
    }

    /**
     * Test to edit an existing project.
     *
     * @return void
     */
    public function testEditProject()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);


        $projectedRevenue = ($project->projectedRevenue = 20.00 ? 21.00 : 20.00);
        $projectedCost = ($project->projectedCost = 8.00 ? 9.00 : 8.00);
        $projectedTime = ($project->projectedTime = 20 ? 21 : 20);
        $private = ($project->private = 0 ? 1 : 0);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => $projectedRevenue,
                    'projectedCost' => $projectedCost,
                    'projectedTime' => $projectedTime,
                    'private' => $private,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Project 2',
            'description' => 'Description for Project 2',
            'projectedRevenue' => $projectedRevenue,
            'projectedCost' => $projectedCost,
            'projectedTime' => $projectedTime,
            'private' => $private,
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Project successfully updated', $data['messages']);
    }

    /**
     * Test to delete an existing project
     *
     * @return void
     */
    public function testDeleteProject()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create();
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
        ]);
        $response = $this->call('post', '/projects/delete/'.$project->id,
            array(
                '_token' => csrf_token(),
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Project deleted', $data['messages']['0']);
    }

    /**
     * Test to delete an exising project without passing
     * the projectID to be deleted.
     *
     * @return void
     */
    public function testDeleteProjectNoId()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $response = $this->call('post', '/projects/delete/',
            array(
                '_token' => csrf_token(),
            ));

        $this->assertEquals(404, $response->getStatusCode());

        //ToDo: make 404 page
        //should redirect to  a custom 404 page
    }

    /**
     * Test to delete an exising project by passing
     * an invalid projectID.
     *
     * @return void
     */
    public function testDeleteProjectInvalidId()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $response = $this->call('post', '/projects/delete/19023842093854',
            array(
                '_token' => csrf_token(),
            ));

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Project not found', $data['messages'][0]);
    }

    /**
     * Test to add a user to a project by updating the
     * project_user_pivot table.
     *
     * @return void
     */
    public function testAddUser()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $project = factory(Project::class)->create();
        $response = $this->call('POST', '/projects/'.$project->id.'/addUser/'.$user->id,
            array(
                '_token' => csrf_token(),
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('project_user_pivot', [
            'userID' => $user->id,
            'projectID' => $project->id,
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }

    /**
     * Test to add a user to a project by updating the
     * project_user_pivot table.
     *
     * @return void
     */
    public function testAddExistingUser()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $project = factory(Project::class)->create();
        $project->addUser($user);

        $response = $this->call('POST', '/projects/'.$project->id.'/addUser/'.$user->id,
            array(
                '_token' => csrf_token(),
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('project_user_pivot', [
            'userID' => $user->id,
            'projectID' => $project->id,
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }

    /**
     * Test to remove a user from a project by updating the
     * project_user_pivot table.
     *
     * @return void
     */
    public function testRemoveUser()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $project = factory(Project::class)->create();
        $project->addUser($user);

        $response = $this->call('POST', '/projects/'.$project->id.'/removeUser/'.$user->id,
            array(
                '_token' => csrf_token(),
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('project_user_pivot', [
            'userID' => $user->id,
            'projectID' => $project->id,
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }

    /**
     * Test to edit a project
     * with a missing Title
     *
     * @return void
     */
    public function testEditProjectMissingTitle()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => null,
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'description' => 'Description for Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    /**
     * Test to edit a project
     * with a missing Client ID
     *
     * @return void
     */
    public function testEditProjectMissingClientID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => null,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    /**
     * Test to edit a project
     * with an invalid Client ID
     *
     * @return void
     */
    public function testEditProjectInvalidClientID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);
        $test = ($client->id = 72 ? 73 : 72);


        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $test,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    /**
     * Test to edit a project
     * with a missing Workspace ID
     *
     * @return void
     */
    public function testEditProjectMissingWorkspaceID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.exists', $data['messages']['workspaceID']['0']);
    }

    /**
     * Test to edit a project
     * with an invalid Workspace ID
     *
     * @return void
     */
    public function testEditProjectInvalidWorkspaceID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $test = ($workspace->id = 72 ? 73 : 72);
        $user['current_workspace_id'] = $test;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.exists', $data['messages']['workspaceID']['0']);
    }

    /**
     * Test to edit a project
     * with a missing Start Date
     *
     * @return void
     */
    public function testEditProjectMissingStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => null,
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Please enter a Start Date', $data['messages']['startDate']['0']);
    }

    /**
     * Test to edit a project
     * with an invalid Start Date
     *
     * @return void
     */
    public function testEditProjectInvalidStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '05-03-2017',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['startDate']['0']);
    }

    /**
     * Test to edit a project
     * with a missing End Date
     *
     * @return void
     */
    public function testEditProjectMissingEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '2017-06-05 00:00:00',
                    'endDate' => null,
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Please enter an End Date', $data['messages']['endDate']['0']);
    }

    /**
     * Test to edit a project
     * with an invalid End Date
     *
     * @return void
     */
    public function testEditProjectInvalidEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '2017-06-05 00:00:00',
                    'endDate' => '05-30-2017',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['endDate']['0']);
    }

    /**
     * Test to edit a project
     * with a missing Projected Time
     *
     * @return void
     */
    public function testEditProjectMissingProjectedTime()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => null,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Please entered a projected time', $data['messages']['projectedTime']['0']);
    }

    /**
     * Test to edit a project
     * with an invalid Projected Time
     *
     * @return void
     */
    public function testEditProjectInvalidProjectedTime()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 'two',
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.integer', $data['messages']['projectedTime']['0']);
    }

    /**
     * Test to edit a project
     * with a missing Scope
     *
     * @return void
     */
    public function testEditProjectMissingPrivate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => null,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Please set the Project as Private or Public', $data['messages']['private']['0']);
    }

    /**
     * Test to edit a project
     * with an invalid Scope
     *
     * @return void
     */
    public function testEditProjectInvalidPrivate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 2,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.boolean', $data['messages']['private']['0']);
    }

    public function testCreateProjectNoDescription()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => null,
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }

    public function testEditProjectNoDescription()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => null,
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'title' => 'Project 2',
            'description' => null,
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }

    public function testEditProjectRobustClientID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => '111111111111111111111111111111111111111',
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.integer', $data['messages']['clientID']['0']);
    }

    public function testEditProjectRobustWorkspaceID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = '111111111111111111111111111111111111111';
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.integer', $data['messages']['workspaceID']['0']);
    }

    public function testCreateProjectRobustClientID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => '111111111111111111111111111111111111111',
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.integer', $data['messages']['clientID']['0']);
    }

    public function testCreateProjectRobustWorkspaceID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = '111111111111111111111111111111111111111';


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.integer', $data['messages']['workspaceID']['0']);
    }

    public function testEditProjectInvalidDayStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => null,
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '2017-06-1',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['startDate']['0']);
    }

    public function testEditProjectInvalidYearStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => null,
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '17-06-01',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['startDate']['0']);
    }

    public function testEditProjectInvalidMonthStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => null,
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '2017-6-01',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['startDate']['0']);
    }

    public function testCreateProjectInvalidDayStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-1',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['startDate']['0']);
    }

    public function testCreateProjectInvalidYearStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '17-06-01',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['startDate']['0']);
    }

    public function testCreateProjectInvalidMonthStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-6-01',
                    'endDate' => '2017-06-05 00:00:00',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['startDate']['0']);
    }

    public function testEditProjectInvalidDayEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => null,
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '2017-06-5',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['endDate']['0']);
    }

    public function testEditProjectInvalidYearEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'description' => null,
                    'projectedRevenue' => 20.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 20,
                    'private' => 0,
                    'startDate' => '2017-06-01 00:00:00',
                    'endDate' => '17-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 2',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['endDate']['0']);
    }

    public function testCreateProjectInvalidMonthEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-05 00:00:00',
                    'endDate' => '05-3-2017',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['endDate']['0']);
    }

    public function testCreateProjectInvalidYearEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-05 00:00:00',
                    'endDate' => '17-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['endDate']['0']);
    }

    public function testCreateProjectInvalidDayEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;


        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-05 00:00:00',
                    'endDate' => '2017-06-5',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['endDate']['0']);
    }

    /*public function testEditProjectInvalidMonthEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $user['current_workspace_id'] = $workspace->id;

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedCost' => 8.00,
                    'projectedTime' => 10,
                    'private' => 0,
                    'startDate' => '2017-06-05 00:00:00',
                    'endDate' => '2017-6-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'title' => 'Project 1',
            'endDate' => $project
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('validation.date_format', $data['messages']['endDate']['0']);
    }*/

}
