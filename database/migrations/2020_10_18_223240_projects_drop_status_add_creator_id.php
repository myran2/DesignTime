<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectsDropStatusAddCreatorId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Projects', function (Blueprint $table) {
            $table->dropColumn('status');

            $table->integer('creator_id')->unsigned()->after('id');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Projects', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->after('description');
        });
    }
}
