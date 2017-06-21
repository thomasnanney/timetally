<?php

use Illuminate\Database\Seeder;
use App\Users\Models\User as Users;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create 5 users
        $users = factory(Users::class, 5)->create();

        //create three workspaces for that user


        //create 4 projects per workspace

        //link all 5 users to each of hte workspaces
    }
}
