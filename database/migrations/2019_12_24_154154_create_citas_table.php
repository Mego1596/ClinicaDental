<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('fecha_hora_inicio');
            $table->datetime('fecha_hora_fin');
            $table->string('descripcion')->nullable();
            $table->boolean('asistencia')->default(false);
            $table->boolean('reprogramado')->default(false);
            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->unsignedBigInteger('cita_id')->nullable();
            $table->foreign('cita_id')->references('id')->on('citas');
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
        Schema::dropIfExists('citas');
    }
}
