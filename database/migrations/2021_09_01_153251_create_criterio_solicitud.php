<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriterioSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('aprobacion_criterio');

        Schema::create('criterio_solicitud', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('CASCADE');
            $table->unsignedBigInteger('criterio_id')->nullable();
            $table->foreign('criterio_id')->references('id')->on('criterios')->onDelete('CASCADE');
            $table->integer('porcentaje')->nullable();
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
        Schema::dropIfExists('criterio_solicitud');
    }
}
