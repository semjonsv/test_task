<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->morphs('matchable');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('oponent_id');
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->integer('type');
            $table->timestamps();

            $table->foreign('oponent_id')->references('id')->on('teams');
            $table->foreign('winner_id')->references('id')->on('teams');
            $table->foreign('division_id')->references('id')->on('divisions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
}
