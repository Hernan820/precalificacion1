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
            $table->text("N_dui",255);
            $table->text("telefono",255);
            $table->text("edad",255);
            $table->text("estatus_laborar",255);
            $table->text("tiempo_trabajo",255);
            $table->text("politico",255);
            $table->text("ingresos",255);
            $table->text("codeudor",255);
            $table->text("viven_juntos",255);
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->foreign('id_empresa')->references('id')->on('empresas'); 
            $table->unsignedBigInteger('id_codeudor')->nullable();
            $table->foreign('id_codeudor')->references('id')->on('codeudors'); 
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
