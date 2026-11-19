<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parking', function (Blueprint $table) {
            $table->id();
            $table->string('slot_no');
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('vehicle_no')->nullable();
            $table->string('vehicle_type')->default('Car');
            $table->string('status')->default('Assigned');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parking');
    }
};
