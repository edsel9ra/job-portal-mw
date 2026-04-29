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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name_job');
            $table->text('description');
            $table->decimal('salary', 10, 2);
            $table->enum('status', ['Abierta','Pausada','Cerrada'])->default('Abierta');
            $table->enum('contract_type', ['Término Fijo','Término Indefinido','Obra o Labor','Aprendizaje','Ocasional','Prestación de Servicios'])->nullable();
            $table->dateTime('created_at');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
