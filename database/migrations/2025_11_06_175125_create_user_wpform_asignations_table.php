<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWpformAsignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wpform_asignations', function (Blueprint $table) {
            $table->id();

            // 🔗 Relaciones principales
            $table->unsignedBigInteger('user_id'); // usuario Laravel asignado
            $table->unsignedBigInteger('wpform_entry_id'); // registro del formulario WPForms
            $table->unsignedBigInteger('form_id')->nullable(); // id del formulario (tipo de formulario)

            // ⚙️ Campos de control
            $table->string('status', 50)->default('assigned'); // estado: assigned, contacted, converted, etc.
            $table->timestamp('assigned_at')->useCurrent(); // fecha/hora en que se asignó
            $table->unsignedBigInteger('assigned_by')->nullable(); // si fue asignado manualmente por un admin
            $table->text('notes')->nullable(); // observaciones opcionales

            $table->timestamps();

            // 🔒 Llaves foráneas
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('wpform_entry_id')->references('id')->on('wp_wpforms_db')->onDelete('cascade');
            // // (asegúrate de que 'id' sea la columna primaria real de wp_wpforms_db)

            // // 🔒 Llave foránea opcional si tienes un usuario admin que asigna
            // $table->foreign('assigned_by')->references('id')->on('users')->onDelete('set null');

            // ⚡ Índices y restricciones
            $table->unique(['user_id', 'wpform_entry_id']); // evita duplicados
            $table->index(['form_id', 'status']); // optimiza consultas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wpform_asignations');
    }
}
