<?php
namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Clients\Models\Client as Client;
use App\Projects\Models\Project as Project;
use App\Workspaces\Models\Workspace as Workspace;
use App\Users\Models\User as User;
use App\Timer\Models\TimeEntries as TimeEntries;

class TimeEntryTest extends TestCase
{
    use DatabaseTransactions;

    public function testTimeEntryIndex()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('GET', '/timer/');
        $this->assertEquals(200, $response->getStatusCode());
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTimeEntry()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('time_entries', [
            'description' => 'Description for Timer 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }

    public function testEditTimeEntry()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $timeEntry = factory(TimeEntries::class)->make();
        $response = $this->call('POST', '/timer/edit/'.$timeEntry->id,
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('time_entries', [
            'description' => 'Description for Timer 1'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteTimeEntry()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $timeEntry = factory(TimeEntries::class)->make();
        $response = $this->call('DELETE', '/timer/delete/'.$timeEntry->id,
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
        $response = $this->call('DELETE', '/timer/delete/',
            array(
                '_token' => csrf_token(),
            ));
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteProjectInvalidId()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $response = $this->call('DELETE', '/timer/delete/19023842093854',
            array(
                '_token' => csrf_token(),
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Time Entry not found', $data['messages'][0]);
    }

    public function testCreateTimeEntryMissingWorkspaceID()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => null,
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'worspaceID' => $workspace->id
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a Workspace Name', $data['messages']['name'][0]);
    }

    public function testCreateTimeEntryMissingProjectID()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => null,
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'projectID' => $project->id
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a Project Name', $data['messages']['name'][0]);
    }

    public function testCreateTimeEntryMissingUserID()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => null,
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'userID' => $user->id
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
    }

    public function testCreateTimeEntryMissingClientID()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => null,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'clientID' => $client->id
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
    }

    public function testCreateTimeEntryInvalidWorkspaceID()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => 'string',
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'worspaceID' => $workspace->id
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a Workspace Name', $data['messages']['name'][0]);
    }

    public function testCreateTimeEntryInvalidProjectID()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => 'string',
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'projectID' => $project->id
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a Project Name', $data['messages']['name'][0]);
    }

    public function testCreateTimeEntryInvalidUserID()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => 'string',
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'userID' => $user->id
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
    }

    public function testCreateTimeEntryInvalidClientID()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => 'string',
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'clientID' => $client->id
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
    }

    public function testCreateTimeEntryMissingStartTime()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => null,
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'startTime' => '2017-7-12 22:42:00'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
    }

    public function testCreateTimeEntryMissingEndTime()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => null,
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'endTime' => '2017-7-12 22:50:00'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
    }

    public function testCreateTimeEntryInvalidStartTime()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => 'string',
                    'endTime' => '2017-7-12 22:50:00',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'startTime' => '2017-7-12 22:42:00'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
    }

    public function testCreateTimeEntryInvalidEndTime()
    {
        $user = factory(User::class)->make();
        $this->be($user);
        $client = factory(Client::class)->make();
        $workspace = factory(Workspace::class)->make();
        $project = factory(Project::class)->make();
        $response = $this->call('POST', '/timer',
            array(
                '_token' => csrf_token(),
                'data' => [
                    'workspaceID' => $workspace->id,
                    'projectID' => $project->id,
                    'userID' => $user->id,
                    'clientID' => $client->id,
                    'startTime' => '2017-7-12 22:42:00',
                    'endTime' => 'string',
                    'billable' => false,
                    'description' => 'Description for Timer 1',
                ]
            ));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('time_entries', [
            'endTime' => '2017-7-12 22:50:00'
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
    }


}