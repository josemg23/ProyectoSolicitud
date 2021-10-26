<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecepcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcions', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('solicitud_id')->nullable();
            // $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('cascade');
            $table->unsignedBigInteger('orden_compra_id')->nullable();
            $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('cascade');
            $table->enum('tipo', ['parcial', 'completa']);
            // $table->enum('mode', ['guardar', 'finalizar', 'cancelar'])->nullable();
            $table->enum('documento', ['factura', 'guia-despacho', 'otro']);
            $table->string('num_documento');
            $table->string('monto_documento');
            $table->longText('detalle')->nullable();
            $table->float('monto_total', 20, 2);
            $table->float('diferencia', 20, 2)->nullable();
            $table->enum('tipo_diferencia', ['ingreso', 'egreso'])->nullable();

            $table->longText('observacion')->nullable();
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada']);
            $table->enum('aprobacion', ['finanzas', 'abastecimiento'])->nullable();
            $table->unsignedBigInteger('aprobacion_id')->nullable();
            $table->foreign('aprobacion_id')->references('id')->on('users')->onDelete('cascade');
            $table->longText('observacion_aprobacion')->nullable();

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
        Schema::dropIfExists('recepcions');
    }
}
