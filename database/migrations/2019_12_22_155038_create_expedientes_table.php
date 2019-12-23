<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero_expediente');
            $table->enum('sexo',array('Masculino','Femenino'));
            $table->enum('ocupacion',array('Estudiante','Empleado','Ama de casa','Desempleado','Otros'));
            $table->string('direccion_trabajo')->nullable();
            $table->string('responsable')->nullable();
            $table->string('recomendado')->nullable();
            $table->string('historia_odontologica')->nullable();
            $table->string('historia_medica')->nullable();
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
        Schema::dropIfExists('expedientes');
    }
}
