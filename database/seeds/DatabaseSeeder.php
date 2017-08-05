<?php

use Illuminate\Database\Seeder;
use App\Users\Models\User as Users;
use App\Workspaces\Models\Workspace as Workspace;
use App\Projects\Models\Project as Project;
use App\Clients\Models\Client as Client;
use App\Timer\Models\TimeEntries as TimeEntry;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $num_projects = 30;
        $num_clients = 6;
        $num_workspaces = 1;

        //create a primary user to log in as
        $primaryUser = factory(Users::class)->create([
            'email' => 'test@example.com',
            'current_workspace_id' => 1
        ]);
        //create three workspaces for that user
        $workspaces = factory(Workspace::class, $num_workspaces)->create([
            'ownerID' => $primaryUser->id,
        ]);
        //create 4 sub users
        $subUsers = factory(Users::class, 8)->create([
            'current_workspace_id' => 1
        ]);

        //create clients for the workspaces
        $clients = factory(Client::class, $num_clients)->create();

        //attach users and clients to workspaces
        foreach($workspaces as $workspace){
//            var_dump($workspace);
            //attach primary user
            $workspace->queryUsers()->attach($primaryUser->id, ['admin' => 1]);
            //attach sub users
            foreach($subUsers as $user){
                $workspace->queryUsers()->attach($user->id, ['admin' => 0]);
            }
            //attach clients
            foreach($clients as $client){
                $workspace->queryClients()->attach($client->id);
            }
        }

        //create 4 projects per workspace
        $projects = [];

        $index = 0;
        $workspace = 0;
        for($i = 0; $i < $num_projects; $i ++){
            if($index % $num_workspaces == 0 && $index != 0){
                $workspace++;
                if($workspace == $num_workspaces){
                    $workspace = 0;
                }
            }
            $client = $index % $num_clients;

            echo "PROJECT: $index \t WORKSPACE: $workspace \t CLIENT: $client\n";

            $project = factory(Project::class)->create([
                'clientID' => $clients->get($client)->id,
                'workspaceID' => $workspaces->get($workspace)->id
            ]);

            array_push($projects, $project);

            //link users to project
            //link primary user to all projects
            $project->queryUsers()->attach($primaryUser->id);

            //link all 5 users to each of the projects
            foreach($subUsers as $user){
                $project->queryUsers()->attach($user->id);
                //create some time entries by each user for each project
                $num_entries = rand(7,15);
                factory(TimeEntry::class, $num_entries)->create([
                   'userID' => $user->id,
                    'projectID' => $project->id,
                    'clientID' => $clients->get($client)->id,
                    'workspaceID' => $workspaces->get($workspace)->id
                ]);
            }

            $num_entries = rand(7,15);
            factory(TimeEntry::class, $num_entries)->create([
                'userID' => $primaryUser->id,
                'projectID' => $project->id,
            ]);

            $index++;
        }
    }
}
