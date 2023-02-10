<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornada', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jornada_id');
            $table->integer('user_id');
            $table->string('proyecto');
            $table->date('fecha');
            $table->string('hi');
            $table->string('hf');
            $table->string('observacion')->nullable();
            $table->integer('revisado_por')->nullable();
            $table->date('fecha_revision')->nullable();
            $table->integer('estado');
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
        Schema::dropIfExists('jornada');
    }
}
