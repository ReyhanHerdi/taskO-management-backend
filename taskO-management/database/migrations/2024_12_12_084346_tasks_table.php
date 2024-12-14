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
        Schema::create('tasks', function(Blueprint $table) {
            $table->bigIncrements('id_task')->primary();
            $table->unsignedBigInteger('project_id');
            $table->string('name_task');
            $table->text('description')->nullable();
            $table->dateTime('due');
            $table->enum('status', ['done', 'ongoing', 'pending'])->default('pending');
            $table->timestamps();
            $table->foreign('project_id')->references('id_project')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
