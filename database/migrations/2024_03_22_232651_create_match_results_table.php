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
        Schema::create('match_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('home_team')->references('id')->on('teams');
            $table->bigInteger('away_team')->references('id')->on('teams');
            $table->integer('home_score')->default(0);
            $table->integer('away_score')->default(0);
            $table->string('the_winner')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_results');
    }
};
