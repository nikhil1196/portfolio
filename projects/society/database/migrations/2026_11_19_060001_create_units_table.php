<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('block')->nullable();
            $table->string('flat_no');
            $table->integer('floor')->default(0);
            $table->string('type')->nullable();
            $table->integer('area_sqft')->default(0);
            $table->string('status')->default('Occupied');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
