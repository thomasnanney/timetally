<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTimeReportView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('create view timereports as select time_entries.description, 
        time_entries.workspaceID as workspaceID, projects.clientID as clientID, clients.name as clientName,
        time_entries.projectID as projectID, projects.title as projectTitle,
        time_entries.userID as userID, users.name as userName,
        startTime, endTime, TIMESTAMPDIFF(minute, startTime, endTime) as time from time_entries join
        users on time_entries.userID=users.id 
        join workspaces on time_entries.workspaceID=workspaces.id
        join projects on time_entries.projectID=projects.id
        join clients on projects.id=clients.id;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view if exists timereports');
    }
}
