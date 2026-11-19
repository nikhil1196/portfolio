<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('employees', function (Blueprint $t) {
            $t->text('history')->nullable();
            $t->integer('leave_balance')->default(20);
        });
        Schema::table('attendances', function (Blueprint $t) {
            $t->string('check_out')->nullable();
            $t->boolean('late')->default(0);
        });
        Schema::table('payrolls', fn (Blueprint $t) => $t->date('paid_at')->nullable());
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
        Schema::table('employees', fn (Blueprint $t) => $t->dropColumn(['history','leave_balance']));
        Schema::table('attendances', fn (Blueprint $t) => $t->dropColumn(['check_out','late']));
        Schema::table('payrolls', fn (Blueprint $t) => $t->dropColumn('paid_at'));
    }
};