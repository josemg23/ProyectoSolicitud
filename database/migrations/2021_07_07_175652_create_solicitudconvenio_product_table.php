<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudconvenioProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudconvenio_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('solicitud_convenios_id');
            $table->foreign('solicitud_convenios_id')->references('id')->on('solicitud_convenios')->onDelete('cascade');
            $table->bigInteger('cantidad');
            $table->float('neto', 20, 2);
            $table->timestamps();
        });

        Schema::table('solicitud_convenios', function (Blueprint $table) {
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('cascade');
            $table->unsignedBigInteger('contrato_id')->nullable();
            $table->foreign('contrato_id')->references('id')->on('contrato_suministros')->onDelete('cascade');
            $table->unsignedBigInteger('tipo_contrato_id')->nullable();
            $table->foreign('tipo_contrato_id')->references('id')->on('tipo_contratos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudconvenio_product');
    }
}
