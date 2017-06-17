<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeentries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workspaceID');
            $table->integer('projectID');
            $table->timeTz('startTime');
            $table->timeTz('endTime');
            $table->string('title');
            $table->string('description');
            $table->boolean('billable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timekeeper');
    }
}
