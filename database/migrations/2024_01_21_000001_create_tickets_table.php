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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('prioridad', ['Alta', 'Media', 'Baja']);
            $table->enum('estado', ['Abierto', 'Asignado', 'En espera', 'Resuelto', 'Cerrado'])->default('Abierto');
            $table->string('categoria');
            $table->foreignId('cliente_id')->constrained('users');
            $table->foreignId('tecnico_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};