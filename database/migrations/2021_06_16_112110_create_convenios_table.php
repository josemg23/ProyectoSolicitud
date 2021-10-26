<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConveniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('nota')->nullable();
            $table->float('presupuesto', 20, 2);
            $table->float('saldo', 20, 2);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('cuentas', function (Blueprint $table) {
            $table->unsignedBigInteger('convenio_id')->nullable();
            $table->foreign('convenio_id')->references('id')->on('convenios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convenios');
    }
}
