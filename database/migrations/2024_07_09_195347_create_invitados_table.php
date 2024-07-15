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
            $table->integer('n_invitado');
            $table->text('nombre');
            $table->text('apellido_p');
            $table->text('apellido_m');
            $table->text('dependencia')->nullable();
            $table->text('cargo')->nullable();
            $table->text('area')->nullable();
            $table->string('telefono',10)->nullable();
            $table->string('email')->nullable();
            $table->string('folio')->unique();
            $table->boolean('verificado')->default(0);
            $table->foreignId('evento_id')->constrained();
            $table->time('hora_ingreso')->nullable();
            $table->boolean('status')->default(1);
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
