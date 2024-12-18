<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attachable_type')->nullable();
            $table->unsignedBigInteger('attachable_id')->nullable();
            $table->string('locale', 8)->nullable();
            $table->string('seo_url')->nullable();
            $table->string('seo_title', 60);
            $table->string('seo_description', 160);
            $table->text('seo_content')->nullable();
            $table->string('open_graph_type', 32);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
}
