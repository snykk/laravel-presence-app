<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->dateTime('published_at')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('component_translations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('component_id')->constrained()->onDelete('cascade');
            $table->string('locale', 10);
            $table->string('title', 500)->nullable();
            $table->string('description', 500)->nullable();
            $table->text('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_translations');
        Schema::dropIfExists('components');
    }
}
