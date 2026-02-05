<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('part_id')->nullable()->constrained()->nullOnDelete();
            $table->string('part_name');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_parts');
    }
};
