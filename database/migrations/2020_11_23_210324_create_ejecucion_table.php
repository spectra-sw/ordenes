<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEjecucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ejecucion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordenes_id');
            $table->foreignId('dias_id');
            $table->float('cant', 3, 2);
            $table->string('und');
            $table->string('observacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ejecucion');
    }
}
