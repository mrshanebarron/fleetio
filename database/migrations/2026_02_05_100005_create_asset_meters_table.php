<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_meters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->decimal('value', 12, 1);
            $table->enum('meter_unit', ['miles', 'hours', 'kilometers']);
            $table->timestamp('recorded_at');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['asset_id', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_meters');
    }
};
