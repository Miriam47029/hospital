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
        Schema::create('paciente_medico', function (Blueprint $table) { // Mantengo 'paciente_medico'
            $table->id();
            $table->unsignedBigInteger('medico_id');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('medico_id')->references('id')->on('medicos')
                  ->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente_medico'); // Mantengo 'paciente_medico'
    }
};
