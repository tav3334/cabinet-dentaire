<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->after('patient_id')->constrained()->onDelete('set null');
            $table->time('appointment_time')->nullable()->after('appointment_date');
            $table->integer('duration')->default(30)->after('appointment_time');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['service_id']);
            $table->dropColumn(['patient_id', 'service_id', 'appointment_time', 'duration']);
        });
    }
};
