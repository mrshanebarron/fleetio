<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->nullableMorphs('documentable');
            $table->string('title');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->date('expires_at')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
