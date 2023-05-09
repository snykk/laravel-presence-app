<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableComponentsAddTypeAndOrderFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->string('type', 45)
                ->default('default')
                ->after('name');

            $table->integer('order')
                ->unsigned()
                ->after('id')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('components', function (Blueprint $table) {
                $table->dropColumn('type');
                $table->dropColumn('order');
            });
        }
    }
}
