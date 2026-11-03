<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoSeminarioToSeminariosTable extends Migration
{
    public function up()
    {
        Schema::table('seminarios', function (Blueprint $table) {
            $table->string('tipo_seminario', 30)->nullable()->after('modalidad');
        });
    }

    public function down()
    {
        Schema::table('seminarios', function (Blueprint $table) {
            $table->dropColumn('tipo_seminario');
        });
    }
}
