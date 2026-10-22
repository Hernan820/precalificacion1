<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesAndJustificacionEliminacionToSeminariosTable extends Migration
{
    public function up()
    {
        Schema::table('seminarios', function (Blueprint $table) {
            $table->softDeletes();
            $table->text('justificacion_eliminacion')->nullable();
        });
    }

    public function down()
    {
        Schema::table('seminarios', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('justificacion_eliminacion');
        });
    }
}
