<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_ordens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordenable_id');
            $table->string('ordenable_type');
            $table->string('nombre')->nullable();
            $table->string('extension')->nullable();
            $table->string('archivo');
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
        Schema::dropIfExists('file_ordens');
    }
}
