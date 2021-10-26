<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('cascade');
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('SET NULL');
            $table->string('codigo_proveedor')->nullable();
            $table->string('nom_proveedor')->nullable();
            $table->string('num_orden')->nullable();
            $table->string('path')->nullable();
            $table->float('valor_total', 20, 2)->nullable();
            $table->string('tipo_compra')->nullable();
            $table->unsignedBigInteger('encargado_id')->nullable();
            $table->foreign('encargado_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->longText('observacion')->nullable();
            $table->longText('xml_data')->nullable();
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
        Schema::dropIfExists('orden_compras');
    }
}
