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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title'); // Ex: "Détartrage", "Extraction molaire"
            $table->text('description')->nullable(); // Description détaillée du traitement
            $table->string('tooth_number')->nullable(); // Numéro de la dent (ex: "16", "21")
            $table->enum('category', [
                'consultation',
                'preventive', // Préventif
                'restorative', // Restauration
                'endodontic', // Endodontie (canal)
                'periodontic', // Parodontie (gencives)
                'surgery', // Chirurgie
                'prosthetic', // Prothèse
                'orthodontic', // Orthodontie
                'cosmetic', // Esthétique
                'emergency', // Urgence
                'other'
            ])->default('other');
            $table->enum('status', [
                'planned', // Planifié
                'in_progress', // En cours
                'completed', // Terminé
                'cancelled', // Annulé
                'on_hold' // En attente
            ])->default('planned');
            $table->decimal('estimated_cost', 10, 2)->nullable(); // Coût estimé
            $table->decimal('actual_cost', 10, 2)->nullable(); // Coût réel
            $table->date('planned_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->integer('sessions_required')->default(1); // Nombre de séances nécessaires
            $table->integer('sessions_completed')->default(0); // Nombre de séances complétées
            $table->text('notes')->nullable(); // Notes du praticien
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
