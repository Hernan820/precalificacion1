<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seminario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo',
        'slug',
        'resumen',
        'descripcion',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'registro_hasta',
        'lugar',
        'direccion',
        'ciudad',
        'estado',
        'mapa_url',
        'modalidad',
        'cupos',
        'tipo_registro',
        'telefono',
        'imagen',
        'formulario_id',
        'justificacion_eliminacion',
        'estatus',
        'activo',
    ];

    protected $casts = [
        'fecha' => 'date',
        'registro_hasta' => 'datetime',
        'activo' => 'boolean',
    ];
}
