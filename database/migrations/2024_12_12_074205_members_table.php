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
        Schema::create('members', function(Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('team_id');
            $table->enum('role', ['leader', 'coordinator', 'member'])->default('member');
            $table->timestamps();
            $table->primary(['user_id', 'team_id']);
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('id_team')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
