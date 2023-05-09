<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslatableStaticPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('static_pages');

        Schema::create('static_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('layout');
            $table->dateTime('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('static_page_translations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('static_page_id')->unsigned();
            $table->string('locale', 10);
            $table->string('name');
            $table->string('slug')->unique();
            $table->mediumText('content');
            $table->string('youtube_video')->nullable();

            $table->foreign('static_page_id')
                ->references('id')
                ->on('static_pages')
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
        Schema::dropIfExists('static_page_translations');
        Schema::dropIfExists('static_pages');

        Schema::create('static_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->mediumText('content');
            $table->string('youtube_video')->nullable();
            $table->string('layout');
            $table->string('published');
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
