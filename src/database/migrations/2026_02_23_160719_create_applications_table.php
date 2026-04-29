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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Campos de tabla aplicaciones
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained('candidates')->cascadeOnDelete();
            //proteccion 1-1
            $table->unique(['job_id', 'candidate_id']);
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['Aplicado', 'En Revisión', 'Entrevista', 'Rechazado', 'Contratado'])->default('Aplicado');
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('reviewed_at')->useCurrentOnUpdate()->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
