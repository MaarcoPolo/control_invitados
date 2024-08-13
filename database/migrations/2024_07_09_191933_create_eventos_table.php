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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->text('organizador');
            $table->text('sede');
            $table->text('domicilio_sede');
            $table->date('fecha_inicial');
            $table->date('fecha_final');
            $table->time('horario');
            $table->text('ubicacion');
            $table->string('logo');
            $table->string('fondo');
            $table->boolean('status')->default(1);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
