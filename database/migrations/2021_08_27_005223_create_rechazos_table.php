<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRechazosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rechazos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->required();
            $table->string('slug')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('aprobacions', function (Blueprint $table) {
            $table->unsignedBigInteger('rechazo_id')->nullable();
            $table->foreign('rechazo_id')->references('id')->on('rechazos')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rechazos');
    }
}
