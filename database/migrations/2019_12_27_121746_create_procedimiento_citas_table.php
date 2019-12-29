<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedimientoCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedimiento_citas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cita_id')->nullable();
            $table->foreign('cita_id')->references('id')->on('citas')->onDelete('cascade');
            $table->unsignedBigInteger('procedimiento_id')->nullable();
            $table->decimal('honorarios',5,2)->default(0);
            $table->integer('numero_piezas')->default(0);
            $table->foreign('procedimiento_id')->references('id')->on('procedimientos');
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
        Schema::dropIfExists('procedimiento_citas');
    }
}
