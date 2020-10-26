<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaskPriorityDropTaskUserOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('priority')->default(0)->after('project_id');
        });

        Schema::table('task_user', function (Blueprint $table) {
            $table->dropColumn(['sort_order']);
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
            $table->dropColumn(['priority']);
        });

        Schema::table('task_user', function (Blueprint $table) {
            $table->integer('sort_order')->default(0);
        });
    }
}
