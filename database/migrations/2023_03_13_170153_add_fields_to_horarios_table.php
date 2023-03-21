<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horarios', function (Blueprint $table) {
            //
            $table->integer('dia_inicio')->nullable();
            $table->integer('dia_fin')->nullable();
            $table->float('hora_inicio')->nullable();
            $table->float('hora_fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('horarios', function (Blueprint $table) {
            //
            $table->dropColumn(['dia_inicio','dia_fin','hora_inicio','hora_fin']);
        });
    }
}
