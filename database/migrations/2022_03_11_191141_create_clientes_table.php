<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->text("nombre",255);
            $table->text("apellidos",255);
            $table->text("correo",255);
            $table->text("medio_contacto",255);
            $table->text("telefono",255);
            $table->text("estatus_laboral",255);
            $table->text("estatus_soscial",255);
            $table->text("horario_contacto",255);
            $table->text("comentarios",255);
            
            $table->unsignedBigInteger('id_prestamo')->nullable();
            $table->foreign('id_prestamo')->references('id')->on('prestamos'); 
            $table->unsignedBigInteger('id_vivienda')->nullable();
            $table->foreign('id_vivienda')->references('id')->on('viviendas'); 
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
        Schema::dropIfExists('clientes');
    }
}
