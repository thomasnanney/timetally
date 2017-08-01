<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleToUserWorkspacePivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_workspace_pivot', function (Blueprint $table) {
            $table->boolean('admin')->after('workspaceID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_workspace_pivot', function (Blueprint $table) {
            $table->dropColumn('admin');
        });
    }
}
