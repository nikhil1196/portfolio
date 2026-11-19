<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('tickets', fn (Blueprint $t) => $t->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete());
        Schema::table('replies', function (Blueprint $t) {
            $t->timestamp('approved_at')->nullable();
            $t->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
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
        Schema::table('tickets', fn (Blueprint $t) => $t->dropConstrainedForeignId('customer_id'));
        Schema::table('replies', function (Blueprint $t) {
            $t->dropConstrainedForeignId('approved_by');
            $t->dropColumn('approved_at');
        });
    }
};