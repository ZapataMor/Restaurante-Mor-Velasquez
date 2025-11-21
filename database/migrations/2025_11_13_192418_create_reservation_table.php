<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Datos ingresados por cualquier cliente desde la web
            $table->string('client_name');
            $table->string('client_contact');
            $table->string('client_document');

            // Para saber cuántas personas vienen
            $table->unsignedInteger('people_count');

            // Fecha y hora de la reserva
            $table->dateTime('reservation_time');

            // Estado de la reserva
            $table->enum('status', ['pendiente', 'confirmada', 'cancelada', 'completada'])
                ->default('pendiente');

            // Mesero asignado automáticamente por el sistema
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Mesa que asigna el Recepcionista
            $table->foreignId('table_id')
                ->nullable()
                ->constrained('tables')
                ->nullOnDelete();

            // Notas opcionales
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
