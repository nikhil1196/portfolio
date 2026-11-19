<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('students', function (Blueprint $t) {
            $t->string('parent_email')->nullable();
            $t->string('document')->nullable();
        });
        Schema::create('fee_structures', function (Blueprint $t) {
            $t->id();
            $t->foreignId('class_id')->constrained('school_classes')->cascadeOnDelete();
            $t->string('term');
            $t->decimal('amount', 10, 2);
            $t->timestamps();
        });
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
        Schema::dropIfExists('fee_structures');
        Schema::table('students', fn (Blueprint $t) => $t->dropColumn(['parent_email','document']));
    }
};