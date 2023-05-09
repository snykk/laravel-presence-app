<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivacyPolicyDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privacy_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('privacy_policy_id')->constrained()->onDelete('cascade');
            $table->boolean('published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->integer('order')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('privacy_detail_translations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('privacy_detail_id')->constrained()->onDelete('cascade');
            $table->string('locale', 10)->nullable();
            $table->string('title', 255);
            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('privacy_details', function (Blueprint $table) {
            $table->dropForeign(['privacy_policy_id']);
        });
        Schema::table('privacy_detail_translations', function (Blueprint $table) {
            $table->dropForeign(['privacy_detail_id']);
        });
        Schema::dropIfExists('privacy_details');
        Schema::dropIfExists('privacy_detail_translations');
    }
}
