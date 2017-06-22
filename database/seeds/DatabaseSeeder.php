<?php

use Illuminate\Database\Seeder;
use App\Users\Models\User as Users;
use App\Workspaces\Models\Workspace as Workspace;
use App\Projects\Models\Project as Project;
use App\Clients\Models\Client as Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //create a primary user to log in as
        $primaryUser = factory(Users::class)->create([
           'email' => 'test@example.com'
        ]);
        //create 4 sub users
        $subUsers = factory(Users::class, 4)->create();

        //create three workspaces for that user
        $workspaces = factory(Workspace::class, 3)->create([
            'ownerID' => $primaryUser->id,
        ]);

        //create clients for the workspaces
        $clients = factory(Client::class, 2)->create();

        //attach users and clients to workspaces
        foreach($workspaces as $workspace){
//            var_dump($workspace);
            //attach primary user
            $workspace->queryUsers()->attach($primaryUser->id);
            //attach sub users
            foreach($subUsers as $user){
                $workspace->queryUsers()->attach($user->id);
            }
            //attach clients
            foreach($clients as $client){
                $workspace->queryClients()->attach($client->id);
            }
        }

        //create 4 projects per workspace
        $projects = [];

        $index = 0;
        $client = 0;
        $workspace = 0;
        for($i = 0; $i < 16; $i ++){
            if($index % 4 == 0 && $workspace != 0){
                $workspace++;
            }
            if($index % 2 == 0){
                $client = ($client == 0 ? 1 : 0);
            }

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
            }

            $index++;
        }
    }
}
