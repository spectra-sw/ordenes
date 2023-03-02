<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColummsToJornada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jornada', function (Blueprint $table) {
            //
            $table->string('duracion')->after('hf')->nullable();
            $table->date('fechaf')->after('duracion')->nullable();
            $table->float('almuerzo')->after('fechaf')->default(0);
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jornada', function (Blueprint $table) {
            
            $table->dropColumn(['duracion','fechaf','almuerzo']);
        });
    }
}
