<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seminarios', function (Blueprint $table) {
            $table->id();

            // Información general
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->string('resumen', 500)->nullable();
            $table->text('descripcion')->nullable();

            // Fecha y horario
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();
            $table->dateTime('registro_hasta')->nullable();

            // Ubicación
            $table->string('lugar');
            $table->string('direccion', 500)->nullable();
            $table->string('ciudad', 150)->nullable();
            $table->string('estado', 150)->nullable();
            $table->string('mapa_url', 500)->nullable();

            // Características del seminario
            $table->string('modalidad', 30)->default('presencial');
            $table->unsignedInteger('cupos')->nullable();

            // Registro
            $table->string('tipo_registro', 20)->default('ambos');
            $table->string('telefono', 30)->nullable();

            // Imagen y formulario
            $table->string('imagen', 500)->nullable();
            $table->unsignedBigInteger('formulario_id')->nullable();

            // Control
            $table->string('estatus', 20)->default('borrador');
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seminarios');
    }
}
