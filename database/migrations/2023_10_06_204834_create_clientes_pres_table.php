<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesPresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_pres', function (Blueprint $table) {
            $table->id();
            $table->text("nombre_cliente",255);
            $table->text("telefono",255);
            $table->text("estado",255);
            $table->text("tipo_trabajo",255);
            $table->text("estatus",255);
            $table->text("hora_precio",255);
            $table->text("num_hora",255);
            $table->text("taxes2021",255);
            $table->text("taxes2022",255);
            $table->text("dowpayment",255);
            $table->text("comentarios",255);
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
        Schema::dropIfExists('clientes_pres');
    }
}
