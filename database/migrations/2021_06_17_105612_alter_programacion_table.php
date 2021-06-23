<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProgramacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('programacion', function (Blueprint $table) {
            //
            $table->string('hi')->nullable();
            $table->string('hf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programacion', function (Blueprint $table) {
            //
            $table->dropColumn(['hf','hf']);
        });
    }
}
