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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            
            // Información del currículum
            // Relación con el candidato
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->string('summary')->nullable();
            $table->json('work_experience')->nullable(); // Almacena experiencia laboral en formato JSON
            $table->json('education')->nullable(); // Almacena educación en formato JSON
            $table->json('skills')->nullable(); // Almacena habilidades en formato JSON
            $table->json('certifications')->nullable(); // Almacena certificaciones en formato JSON
            $table->json('languages')->nullable(); // Almacena idiomas en formato JSON
            $table->string('pdf_path')->nullable(); // Ruta al archivo PDF del currículum
            $table->string('pdf_mime', 80)->nullable(); // Tipo MIME del archivo PDF del currículum
            $table->unsignedInteger('pdf_size')->nullable(); // Tamaño del archivo PDF del currículum en bytes

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
