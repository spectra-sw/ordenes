<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCdcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdc', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->string('descripcion');
            $table->string('centro_operacion');
            $table->string('unidad_negocio');
            $table->string('responsable');
            $table->string('mayor');
            $table->string('grupo');
            $table->string('observaciones');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdc');
    }
}
