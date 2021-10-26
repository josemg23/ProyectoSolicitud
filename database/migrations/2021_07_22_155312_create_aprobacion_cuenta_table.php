<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAprobacionCuentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aprobacion_cuenta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aprobacion_id')->nullable();
            $table->foreign('aprobacion_id')->references('id')->on('aprobacions')->onDelete('cascade');
            $table->unsignedBigInteger('cuenta_id')->nullable();
            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');
            $table->float('monto', 20, 2)->nullable();
            $table->timestamps();
        });
        Schema::table('aprobacions', function (Blueprint $table) {
            $table->boolean('multiple')->default(0);
            $table->unsignedBigInteger('cuenta_id')->nullable();
            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aprobacion_cuenta');
    }
}
