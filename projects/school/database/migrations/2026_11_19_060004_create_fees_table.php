<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no')->nullable();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('term')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('status')->default('Paid');
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
