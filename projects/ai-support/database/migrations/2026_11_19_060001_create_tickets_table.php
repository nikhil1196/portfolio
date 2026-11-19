<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->nullable();
            $table->string('customer');
            $table->string('email')->nullable();
            $table->string('subject');
            $table->string('channel')->default('Email');
            $table->string('priority')->default('Medium');
            $table->string('status')->default('Open');
            $table->foreignId('agent_id')->nullable()->constrained()->nullOnDelete();
            $table->text('ai_summary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
