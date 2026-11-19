<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_no')->nullable();
            $table->foreignId('deal_id')->constrained('deals')->cascadeOnDelete();
            $table->string('title');
            $table->decimal('amount', 10, 2)->default(0);
            $table->date('valid_until');
            $table->string('status')->default('Draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
