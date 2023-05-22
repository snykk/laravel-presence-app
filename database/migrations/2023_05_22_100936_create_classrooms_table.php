<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('building_id')->unsigned();
            $table->string('room_number', 1);
            $table->smallInteger('capacity')->unsigned();
            $table->smallInteger('floor')->unsigned();
            $table->string('status', 30); // active, and under maintenance
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();


            $table->foreign('building_id')
                ->references('id')
                ->on('buildings')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
}
