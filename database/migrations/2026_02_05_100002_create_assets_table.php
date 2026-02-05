<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['vehicle', 'trailer', 'equipment']);
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('vin')->nullable();
            $table->string('license_plate')->nullable();
            $table->enum('status', ['active', 'inactive', 'in_shop', 'out_of_service'])->default('active');
            $table->string('group')->nullable();
            $table->string('photo')->nullable();
            $table->decimal('current_meter_value', 12, 1)->default(0);
            $table->enum('meter_unit', ['miles', 'hours', 'kilometers'])->default('miles');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
