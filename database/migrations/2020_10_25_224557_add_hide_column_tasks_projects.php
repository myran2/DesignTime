<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHideColumnTasksProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->binary('hide')->default(0)->after('project_id');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->binary('hide')->default(0)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['hide']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['hide']);
        });
    }
}
