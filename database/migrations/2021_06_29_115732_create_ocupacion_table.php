<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOcupacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocupacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cc');
            $table->date('dia');
            $table->integer('area');
            $table->integer('proyecto');
            $table->integer('actividad');
            $table->integer('horas');
            $table->integer('minutos');
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
        Schema::dropIfExists('ocupacion');
    }
}
