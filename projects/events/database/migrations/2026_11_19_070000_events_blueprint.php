<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('events', function (Blueprint $t) {
            $t->string('organizer')->nullable();
            $t->string('organizer_contact')->nullable();
        });
        Schema::table('tickets', fn (Blueprint $t) => $t->integer('sold')->default(0));
        Schema::table('bookings', function (Blueprint $t) {
            $t->foreignId('ticket_id')->nullable()->constrained('tickets')->nullOnDelete();
            $t->string('payment')->default('Unpaid');
            $t->string('txn_ref')->nullable();
        });
        Schema::table('attendees', fn (Blueprint $t) => $t->string('checkin_code')->nullable()->unique());
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
        Schema::table('events', fn (Blueprint $t) => $t->dropColumn(['organizer','organizer_contact']));
        Schema::table('tickets', fn (Blueprint $t) => $t->dropColumn('sold'));
        Schema::table('bookings', fn (Blueprint $t) => $t->dropColumn(['ticket_id','payment','txn_ref']));
        Schema::table('attendees', fn (Blueprint $t) => $t->dropColumn('checkin_code'));
    }
};