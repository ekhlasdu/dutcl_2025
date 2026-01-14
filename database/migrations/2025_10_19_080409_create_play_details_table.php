<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_details', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->unsignedBigInteger('user_id');

            $table->string('profile_image')->nullable();
            $table->string('department');
            $table->string('designation');

            $table->enum('batting', ['Just for Fun', 'Good', 'Excellent'])->nullable();
            $table->enum('bowling', ['Just for Fun', 'Good', 'Excellent'])->nullable();
            $table->enum('keeping', ['Just for Fun', 'Good', 'Excellent'])->nullable();

            $table->enum('played_as_student', ['Yes', 'No'])->default('No');
            $table->enum('played_dutcl', ['Yes', 'No'])->default('No');

            $table->string('ptype')->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade'); // When user deleted, details deleted
        });
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        Schema::dropIfExists('player_details');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
};
