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
    Schema::create('weekly_updates', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        $table->string('reporting_week')->nullable();

        $table->string('project_name')->nullable();
        $table->string('project_priority')->nullable();

        $table->date('deadline_date')->nullable();

        $table->decimal('estimated_hours',8,2)->nullable();
        $table->decimal('actual_hours_worked',8,2)->nullable();

        $table->longText('activities_completed')->nullable();
        $table->longText('issues_faced')->nullable();

        $table->string('project_status')->nullable();

        $table->longText('client_feedback')->nullable();
        $table->longText('plan_for_next_week')->nullable();
        $table->longText('learning_update')->nullable();
        $table->longText('key_outcomes')->nullable();
        $table->longText('additional_notes')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_updates');
    }
};
