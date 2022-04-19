<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AutorizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('autorizaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proyecto',100);
            $table->string('trabajador',30);
            $table->longText('motivo')->nullable();
            $table->date('fecha');
            $table->string('horario_habitual',5)->nullable();
            $table->string('hora_entrada',5);
            $table->string('hora_autorizada_salida',5);
            $table->longText('observaciones')->nullable();
            $table->integer('autorizado_por')->nullable();
            $table->integer('director')->nullable();
            $table->integer('talento')->nullable();
            $table->date('fecha_autorizacion')->nullable();
            $table->date('fecha_vobo_director')->nullable();
            $table->date('fecha_vobo_talento')->nullable();
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
        //
        Schema::dropIfExists('autorizaciones');
    }
}
