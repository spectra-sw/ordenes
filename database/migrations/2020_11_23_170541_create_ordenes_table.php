<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->string('proyecto');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->string('responsable');
            $table->string('cliente');
            $table->string('area_trabajo');
            $table->string('contacto');
            $table->string('tipo');
            $table->string('objeto');
            $table->longText('observaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenes');
    }
}
