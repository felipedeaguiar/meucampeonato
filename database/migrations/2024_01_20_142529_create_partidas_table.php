<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('time1_id');
            $table->unsignedBigInteger('time2_id');
            $table->integer('time1_placar')->default(0);
            $table->integer('time2_placar')->default(0);
            $table->integer('fase');
            $table->unsignedBigInteger('campeonato_id')->index();
            $table->unsignedBigInteger('vencedor_id')->nullable();
            $table->foreign('time1_id')->references('id')->on('times');
            $table->foreign('time2_id')->references('id')->on('times');
            $table->foreign('vencedor_id')->references('id')->on('times');
            $table->foreign('campeonato_id')->references('id')->on('campeonatos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
