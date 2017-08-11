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

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
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

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => null,
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'description' => 'Description for Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
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

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => null,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
        $test = ($client->id = 1 ? 2 : 1);

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $test,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
                    'workspaceID' => null,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
        $test = ($workspace->id = 1 ? 2 : 1);

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $test,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => null,
                    'endDate' => '2017-06-05',
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

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '05-03-2017', //invalid format
                    'endDate' => '2017-06-05',
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

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => null,
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

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-05-30', //end date must be after startDate
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

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => null,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => '2 days', //must be an integer
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
     * Test to create a new project
     * with a missing Billable Type
     *
     * @return void
     */
    public function testCreateProjectMissingBillableType()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => null,
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
     * Test to create a new project
     * with an invalid Billable Type
     *
     * @return void
     */
    public function testCreateProjectInvalidBillableType()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'by user', // must be hourly or fixed
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
     * Test to create a new project
     * with a missing Scope
     *
     * @return void
     */
    public function testCreateProjectMissingScope()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'fixed',
                    'scope' => null,
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
     * Test to create a new project
     * with an invalid Scope
     *
     * @return void
     */
    public function testCreateProjectInvalidScope()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'by user',
                    'scope' => 'none', // must be public or private
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
     * Test to edit an existing project.
     * Updates the record's Title, description, projectedRevenue, projectedTime,
     * billableType, scope, billableHourlyType, billableRate,
     * startDate, and endDate
     *
     * @return void
     */
    public function testEditProject()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create([
            'clientID' => $client->id,
            'workspaceID' => $workspace->id,
        ]);
        $scope = ($project->scope = 'private' ? 'public' : 'private');
        $billableType = ($project->billableType = 'fixed' ? 'hourly' : 'fixed');

        $response = $this->call('POST', '/projects/edit/'.$project->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 2',
                    'clientID' => $project->clientID,
                    'workspaceID' => $project->workspaceID,
                    'description' => 'Description for Project 2',
                    'projectedRevenue' => 20.00,
                    'projectedTime' => 20,
                    'billableType' => $billableType,
                    'scope' => $scope,
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Project 2',
            'billableType' => $billableType,
            'scope' => $scope,
            'billableHourlyType' => 'none',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
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
        $this->assertEquals('success', $data['status']);
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

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
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
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => null,
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'description' => 'Description for Project 1',
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
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => null,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
        $test = ($client->id = 1 ? 2 : 1);
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $test,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => null,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
        $test = ($workspace->id = 1 ? 2 : 1);
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $test,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => null,
                    'endDate' => '2017-06-05',
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
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '05-03-2017', //invalid format
                    'endDate' => '2017-06-05',
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
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => null,
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
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-05-30', //end date must be after startDate
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
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => null,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => '2 days', //must be an integer
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
     * with a missing Billable Type
     *
     * @return void
     */
    public function testEditProjectMissingBillableType()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => null,
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
     * with an invalid Billable Type
     *
     * @return void
     */
    public function testEditProjectInvalidBillableType()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'by user', // must be hourly or fixed
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
     * with a missing Scope
     *
     * @return void
     */
    public function testEditProjectMissingScope()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'fixed',
                    'scope' => null,
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
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
     * with an invalid Scope
     *
     * @return void
     */
    public function testEditProjectInvalidScope()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'by user',
                    'scope' => 'none', // must be public or private
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testCreateProjectNoDescription()

    {

        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/create',

            array(

                '_token' => csrf_token(),

                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => null,
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'by user',
                    'scope' => 'none', // must be public or private
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('projects', [

            'name' => 'Project 1'

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
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/create',

            array(

                '_token' => csrf_token(),

                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => null,
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'by user',
                    'scope' => 'none', // must be public or private
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('projects', [

            'name' => 'Project 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);

    }

    public function testEditProjectRobustClientID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => '111111111111111111111111111111111111111',
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testEditProjectRobustWorkspaceID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();
        $client = factory(Client::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => '111111111111111111111111111111111111111',
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testCreateProjectRobustClientID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => '111111111111111111111111111111111111111',
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testCreateProjectRobustWorkspaceID()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();
        $client = factory(Client::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => '111111111111111111111111111111111111111',
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01',
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testEditProjectInvalidDayStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-1', //invalid day format
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }
    public function testEditProjectInvalidYearStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '17-06-01', //invalid  year format
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testEditProjectInvalidMonthStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-6-01', //invalid  month format
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testCreateProjectInvalidDayStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-1', //invalid day format
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }
    public function testCreateProjectInvalidYearStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '17-06-01', //invalid  year format
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testCreateProjectInvalidMonthStartDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-6-01', //invalid  month format
                    'endDate' => '2017-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testEditProjectInvalidDayEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01', //invalid day format
                    'endDate' => '2017-06-5',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }
    public function testEditProjectInvalidYearEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01', //invalid  year format
                    'endDate' => '17-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testEditProjectInvalidMonthEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/edit/{$project}',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01', //invalid  month format
                    'endDate' => '2017-6-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testCreateProjectInvalidDayEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01', //invalid day format
                    'endDate' => '2017-06-5',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }
    public function testCreateProjectInvalidYearEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01', //invalid  year format
                    'endDate' => '17-06-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }

    public function testCreateProjectInvalidMonthEndDate()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $client = factory(Client::class)->create();
        $workspace = factory(Workspace::class)->create();
        $project = factory(Project::class)->create();

        $response = $this->call('POST', '/projects/create',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'title' => 'Project 1',
                    'clientID' => $client->id,
                    'workspaceID' => $workspace->id,
                    'description' => 'Description for Project 1',
                    'projectedRevenue' => 10.00,
                    'projectedTime' => 10,
                    'billableType' => 'hourly',
                    'scope' => 'public',
                    'billableHourlyType' => 'none',
                    'billableRate' => '1000',
                    'startDate' => '2017-06-01', //invalid  month format
                    'endDate' => '2017-6-05',
                ]
            ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('projects', [
            'title' => 'Project 1',
        ]);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
    }


}
