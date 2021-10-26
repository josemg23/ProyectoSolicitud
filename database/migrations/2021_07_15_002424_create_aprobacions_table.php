<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAprobacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aprobacions', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->nullable();
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('cascade');
            $table->unsignedBigInteger('encargado_id');
            $table->foreign('encargado_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('estado', ['aprobado', 'rechazado']);
            $table->text('observacion')->nullable();
            $table->text('condicion_entrega')->nullable();
            $table->text('modalidad_compra')->nullable();
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
        Schema::dropIfExists('aprobacions');
    }
}
