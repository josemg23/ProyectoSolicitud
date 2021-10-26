<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_compras', function (Blueprint $table) {
            $table->enum('recepcion', ['pendiente', 'recepcionada', 'recepcionada-parcial', 'cancelada', 'eliminada'])->default('pendiente');
        });

        Schema::table('solicituds', function (Blueprint $table) {
            $table->text('modalidad_compra')->nullable();
        });
        // Schema::table('recepcions', function (Blueprint $table) {
        //     $table->unsignedBigInteger('orden_compra_id')->nullable();
        //     $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
