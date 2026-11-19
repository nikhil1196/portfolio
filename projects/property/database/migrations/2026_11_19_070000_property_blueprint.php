<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('properties', fn (Blueprint $t) => $t->string('image')->nullable());
        Schema::table('tenants', fn (Blueprint $t) => $t->string('document')->nullable());
        Schema::table('leases', fn (Blueprint $t) => $t->integer('renewals')->default(0));
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
        Schema::table('properties', fn (Blueprint $t) => $t->dropColumn('image'));
        Schema::table('tenants', fn (Blueprint $t) => $t->dropColumn('document'));
        Schema::table('leases', fn (Blueprint $t) => $t->dropColumn('renewals'));
    }
};