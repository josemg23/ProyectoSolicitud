<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->text('adquisicion')->nullable();
            $table->text('descripcion')->nullable();
            $table->date('fecha_creacion');
            $table->unsignedBigInteger('dependencia_id')->nullable();
            $table->foreign('dependencia_id')->references('id')->on('dependencias')->onDelete('cascade');
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
            $table->float('total_neto', 20, 2)->nullable()->default(0);
            $table->float('iva', 20, 2)->nullable()->default(0);
            $table->float('total', 20, 2)->nullable()->default(0);
            $table->enum('estado', ['rechazada', 'en proceso', 'borrador', 'completada', 'aprobado', 'eliminado', 'anulada', 'recepcionada', 'recepcion-parcial',  'completada-parcial', 'cancelada'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('SET NULL');
            $table->unsignedBigInteger('ejecutivo_id')->nullable();
            $table->foreign('ejecutivo_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicituds');
    }
}
