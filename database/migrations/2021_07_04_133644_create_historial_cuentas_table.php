<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_cuentas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historial_cuentable_id');
            $table->string('historial_cuentable_type');
            $table->unsignedBigInteger('cuenta_id');
            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');
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
        Schema::dropIfExists('historial_cuentas');
    }
}
