<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('player_detail_id');
            $table->unsignedBigInteger('team_id'); // ✅ FIXED TYPE
            $table->unsignedBigInteger('amount');

            $table->timestamps();

            // Foreign keys
            $table->foreign('player_detail_id')
                  ->references('id')->on('player_details')
                  ->onDelete('cascade');

            $table->foreign('team_id')
                  ->references('id')->on('teams')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
