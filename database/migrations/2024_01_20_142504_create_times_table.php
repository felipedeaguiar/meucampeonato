<?php

use App\Models\Time;
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
        Schema::create('times', function (Blueprint $table) {
            $table->id();
            $table->string('nome','200')->unique();
            $table->timestamps();
        });

        Time::create(['nome' => 'Avai']);
        Time::create(['nome' => 'Palmeiras']);
        Time::create(['nome' => 'Figueirense']);
        Time::create(['nome' => 'Corinthians']);
        Time::create(['nome' => 'São Paulo']);
        Time::create(['nome' => 'Gremio']);
        Time::create(['nome' => 'Atlético Mg']);
        Time::create(['nome' => 'Atlético Pr']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('times');
    }
};
