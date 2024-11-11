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
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->string('especialidad', 80);
            $table->string('telefono', 20);
            $table->string('email', 100);
            $table->foreignId('paciente_id')->constrained('pacientes')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};
