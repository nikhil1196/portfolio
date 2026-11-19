<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('members', function (Blueprint $t) {
            $t->string('emergency_name')->nullable();
            $t->string('emergency_phone')->nullable();
            $t->string('photo')->nullable();
            $t->date('expiry_date')->nullable();
            $t->text('notes')->nullable();
        });
        Schema::table('plans', fn (Blueprint $t) => $t->decimal('discount_pct', 5, 2)->default(0));
        Schema::table('trainers', fn (Blueprint $t) => $t->string('availability')->nullable());
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
        Schema::table('members', fn (Blueprint $t) => $t->dropColumn(['emergency_name','emergency_phone','photo','expiry_date','notes']));
        Schema::table('plans', fn (Blueprint $t) => $t->dropColumn('discount_pct'));
        Schema::table('trainers', fn (Blueprint $t) => $t->dropColumn('availability'));
    }
};