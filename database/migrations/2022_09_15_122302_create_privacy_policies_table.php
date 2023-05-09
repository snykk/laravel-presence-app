<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivacyPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privacy_policies', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('slug');
            $table->integer('order')->unsigned()->default(0);
            $table->date('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('privacy_policies_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('privacy_policy_id')->constrained()->onDelete('cascade');
            $table->string('locale', 10)->nullable();
            $table->string('title', 255);
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privacy_policies_translations');
        Schema::dropIfExists('privacy_policies');
    }
}
