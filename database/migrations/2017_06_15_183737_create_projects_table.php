<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->integer('clientID');
            $table->text('title');
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->integer('projectedTime');
            $table->boolean('private');
            $table->integer('workspaceID');
            $table->decimal('projectedRevenue', 20, 2);
            $table->decimal('projectedCost', 20, 2);
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
        Schema::dropIfExists('projects');
    }
}
