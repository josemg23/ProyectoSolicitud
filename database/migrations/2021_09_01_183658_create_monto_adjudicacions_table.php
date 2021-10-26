<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMontoAdjudicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monto_adjudicacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id')->unique();
            $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('CASCADE');
            $table->float('monto', 20, 2)->nullable();
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
        Schema::dropIfExists('monto_adjudicacions');
    }
}
