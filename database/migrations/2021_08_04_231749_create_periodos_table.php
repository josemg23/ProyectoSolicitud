<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio_periodo')->nullable();
            $table->date('fecha_termino_periodo')->nullable();
            $table->unsignedBigInteger('contrato_suministro_id');
            $table->foreign('contrato_suministro_id')->references('id')->on('contrato_suministros')->onDelete('cascade');
            $table->float('monto_inicial', 20, 2);
            $table->float('monto_actual', 20, 2);
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
        Schema::dropIfExists('periodos');
    }
}
