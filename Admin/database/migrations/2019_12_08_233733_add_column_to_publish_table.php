<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPublishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_publishes', function (Blueprint $table) {
            $table->string('education')->nullable();
            $table->string('occupatiion')->nullable();
            $table->string('children_group')->nullable();
            $table->string('children_household')->nullable();
            $table->string('household_category')->nullable();
            $table->string('purchasing_role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_publishes', function (Blueprint $table) {
            //
        });
    }
}
