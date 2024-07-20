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
        Schema::create('invitados', function (Blueprint $table) {
            $table->id();
            // $table->primary(['nombre','apellido_p','apellido_m'],'asignaturas_alumno_pk');
            $table->integer('n_invitado');
            $table->string('nombre');
            $table->string('apellido_p')->nullable();;
            $table->string('apellido_m')->nullable();;
            $table->text('dependencia')->nullable();
            $table->text('cargo')->nullable();
            $table->text('area')->nullable();
            $table->string('telefono',10)->nullable();
            $table->string('email');
            $table->string('folio')->unique();
            $table->boolean('confirmo')->default(0);
            $table->boolean('correo_enviado')->default(0);
            $table->boolean('verificado')->default(0);
            $table->foreignId('evento_id')->constrained();
            $table->foreignId('zona_id')->constrained();
            $table->time('hora_ingreso')->nullable();
            $table->text('estado');
            $table->text('municipio');
            $table->boolean('status')->default(1);
            // $table->unique(['dependencia','cargo','area','telefono','email']);
            // $table->unique(['dependencia','cargo','area']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitados');
    }
};
