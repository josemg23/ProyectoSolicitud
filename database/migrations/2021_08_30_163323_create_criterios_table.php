<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->required();
            $table->enum('estado', ['activo', 'inactivo'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('aprobacion_criterio', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('aprobacion_id');
        //     $table->foreign('aprobacion_id')->references('id')->on('aprobacions')->onDelete('CASCADE');
        //     $table->unsignedBigInteger('criterio_id')->nullable();
        //     $table->foreign('criterio_id')->references('id')->on('criterios')->onDelete('CASCADE');
        //     $table->integer('porcentaje')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criterios');
    }
}
