<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('deals', fn (Blueprint $t) => $t->integer('probability')->default(0));
        Schema::table('quotes', fn (Blueprint $t) => $t->text('terms')->nullable());
        Schema::create('audit_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('action');
            $t->string('model_type')->nullable();
            $t->unsignedBigInteger('model_id')->nullable();
            $t->string('summary')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('audit_logs');
        Schema::table('deals', fn (Blueprint $t) => $t->dropColumn('probability'));
        Schema::table('quotes', fn (Blueprint $t) => $t->dropColumn('terms'));
    }
};