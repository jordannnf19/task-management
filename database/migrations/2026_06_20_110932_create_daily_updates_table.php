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
    Schema::create('daily_updates', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        $table->integer('task_no');

        $table->string('project_name')->nullable();
        $table->string('task_name')->nullable();
        $table->string('priority')->nullable();

        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();

        $table->decimal('estimated_hours',8,2)->nullable();
        $table->decimal('hours_spent',8,2)->nullable();

        $table->string('status')->nullable();

        $table->longText('current_progress')->nullable();
        $table->longText('tomorrows_plan')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_updates');
    }
};
