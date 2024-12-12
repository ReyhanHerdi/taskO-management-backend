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
        Schema::create('projects', function(Blueprint $table) {
            $table->bigIncrements('id_project')->primary();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name_project');
            $table->text('description')->nullable();
            $table->dateTime('due');
            $table->enum('status', ['done', 'ongoing', 'pending'])->default('pending');
            $table->timestamps();
            $table->foreign('team_id')->references('id_team')->on('teams')->onDelete('cascade');
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
