<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('schedule_type', ['time_based', 'meter_based']);
            $table->unsignedInteger('frequency_value');
            $table->enum('frequency_unit', ['days', 'weeks', 'months', 'miles', 'hours']);
            $table->timestamp('last_completed_at')->nullable();
            $table->decimal('last_meter_value', 12, 1)->nullable();
            $table->timestamp('next_due_at')->nullable();
            $table->decimal('next_due_meter', 12, 1)->nullable();
            $table->enum('status', ['active', 'paused'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'next_due_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};
