<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('units', function (Blueprint $t) {
            $t->string('owner_name')->nullable();
            $t->string('owner_phone')->nullable();
        });
        Schema::table('residents', fn (Blueprint $t) => $t->string('document')->nullable());
        Schema::table('complaints', function (Blueprint $t) {
            $t->string('assigned_to')->nullable();
            $t->text('resolution')->nullable();
            $t->timestamp('resolved_at')->nullable();
        });
        Schema::table('visitors', fn (Blueprint $t) => $t->string('approved_by')->nullable());
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
        Schema::table('units', fn (Blueprint $t) => $t->dropColumn(['owner_name','owner_phone']));
        Schema::table('residents', fn (Blueprint $t) => $t->dropColumn('document'));
        Schema::table('complaints', fn (Blueprint $t) => $t->dropColumn(['assigned_to','resolution','resolved_at']));
        Schema::table('visitors', fn (Blueprint $t) => $t->dropColumn('approved_by'));
    }
};