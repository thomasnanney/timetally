<?php

namespace Tests\Unit;

use App\Clients\Models\Client;
use App\Workspaces\Models\Workspace;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Users\Models\User as User;
use App\Projects\Models\Project as Project;

class UserModelTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testQueryUserProjects()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $projects = factory(Project::class, 3)->create();

        foreach($projects as $project){
            $project->queryUsers()->attach($user->id);
        }


    }

    public function testQueryClientsByUser(){
        $user = factory(User::class)->create();
        $this->be($user);

        //create a workspace
        $workspace = factory(Workspace::class)->create();

        $workspace->queryUsers()->attach($user->id);

        //create Clients for that workspace
        $clients = factory(Client::class, 3)->create();
        foreach($clients as $client){
            $workspace->queryClients()->attach($client->id);
        }

        //test that they are in the DB and returned
        $this->assertDatabaseHas('client_workspace_pivot', [
           'workspaceID' => $workspace->id,
            'clientID' => $clients->get(0)->id,
        ]);

        $this->assertDatabaseHas('client_workspace_pivot', [
            'workspaceID' => $workspace->id,
            'clientID' => $clients->get(1)->id,
        ]);

        $this->assertDatabaseHas('client_workspace_pivot', [
            'workspaceID' => $workspace->id,
            'clientID' => $clients->get(2)->id,
        ]);

//        $clientsByUser = $user->getAllClients();

        //ToDo: Assert that clients by user array contains clients above
    }
}
