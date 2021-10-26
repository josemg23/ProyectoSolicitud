<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_contratos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historial_contratable_id');
            $table->string('historial_contratable_type');
            $table->unsignedBigInteger('contrato_suministro_id');
            $table->foreign('contrato_suministro_id')->references('id')->on('contrato_suministros')->onDelete('cascade');
            $table->unsignedBigInteger('periodo_id')->nullable();
            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
            $table->float('cantidad', 20, 2);
            $table->text('detalle')->nullable();
            $table->enum('type', ['ingreso', 'egreso'])->nullable();
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
        Schema::dropIfExists('historial_contratos');
    }
}
