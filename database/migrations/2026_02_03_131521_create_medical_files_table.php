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
        Schema::create('medical_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('consultation_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('treatment_id')->nullable()->constrained()->onDelete('set null');

            $table->string('title'); // Titre du document
            $table->text('description')->nullable();

            $table->enum('type', [
                'xray', // Radiographie
                'scan', // Scanner
                'photo', // Photo
                'document', // Document
                'prescription', // Ordonnance
                'report', // Rapport
                'consent', // Consentement
                'lab_result', // Résultat labo
                'other'
            ])->default('document');

            $table->string('file_path'); // Chemin du fichier dans storage
            $table->string('file_name'); // Nom original du fichier
            $table->string('file_extension')->nullable(); // Extension (pdf, jpg, png, etc.)
            $table->integer('file_size')->nullable(); // Taille en bytes
            $table->string('mime_type')->nullable();

            $table->date('document_date')->nullable(); // Date du document/examen
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_files');
    }
};
