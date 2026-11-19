<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('patients', function (Blueprint $t) {
            $t->text('medical_history')->nullable();
            $t->string('document')->nullable();
        });
        Schema::table('appointments', fn (Blueprint $t) => $t->text('visit_notes')->nullable());
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
        Schema::table('patients', fn (Blueprint $t) => $t->dropColumn(['medical_history','document']));
        Schema::table('appointments', fn (Blueprint $t) => $t->dropColumn('visit_notes'));
    }
};