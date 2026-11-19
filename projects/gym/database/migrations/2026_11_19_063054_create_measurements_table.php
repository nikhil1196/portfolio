<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->date('measured_on');
            $table->decimal('weight_kg', 10, 2)->default(0);
            $table->decimal('height_cm', 10, 2)->default(0);
            $table->decimal('chest_cm', 10, 2)->default(0);
            $table->decimal('waist_cm', 10, 2)->default(0);
            $table->decimal('arms_cm', 10, 2)->default(0);
            $table->decimal('body_fat', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
