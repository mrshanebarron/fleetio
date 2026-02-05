<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('part_number')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->unsignedInteger('quantity_on_hand')->default(0);
            $table->unsignedInteger('minimum_quantity')->default(0);
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
