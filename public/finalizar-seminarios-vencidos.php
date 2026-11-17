<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$fechaActual = Illuminate\Support\Carbon::now()->toDateString();

$actualizados = App\Models\Seminario::query()
    ->where('estatus', 'publicado')
    ->where('activo', true)
    ->whereDate('fecha', '<', $fechaActual)
    ->update(['estatus' => 'finalizado']);

Illuminate\Support\Facades\Log::info(
    'Tarea diaria de seminarios vencidos completada.',
    [
        'fecha' => $fechaActual,
        'actualizados' => $actualizados,
    ]
);

fwrite(STDOUT, "Seminarios marcados como finalizados: {$actualizados}\n");
