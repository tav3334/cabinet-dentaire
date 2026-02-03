<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->date('consultation_date');
            $table->time('consultation_time')->nullable();
            $table->enum('type', [
                'first_visit', // Première visite
                'follow_up', // Suivi
                'emergency', // Urgence
                'control', // Contrôle
                'treatment', // Traitement
                'other'
            ])->default('follow_up');

            // Motif de consultation
            $table->text('chief_complaint')->nullable(); // Motif principal

            // Examen clinique
            $table->text('clinical_examination')->nullable(); // Examen clinique
            $table->text('oral_hygiene')->nullable(); // Hygiène bucco-dentaire
            $table->text('periodontal_status')->nullable(); // État parodontal
            $table->text('dental_chart')->nullable(); // Schéma dentaire (peut stocker JSON)

            // Diagnostic
            $table->text('diagnosis')->nullable();

            // Plan de traitement
            $table->text('treatment_plan')->nullable();

            // Prescriptions
            $table->text('prescriptions')->nullable(); // Médicaments prescrits

            // Recommandations
            $table->text('recommendations')->nullable();

            // Prochain rendez-vous
            $table->date('next_appointment_date')->nullable();

            // Notes générales
            $table->text('notes')->nullable();

            // Signature/Praticien
            $table->foreignId('practitioner_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
