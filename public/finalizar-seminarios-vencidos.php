<?php

header('Content-Type: text/plain; charset=utf-8');

// echo 'Hora del servidor NUEVO: ' . date('Y-m-d H:i:s') . PHP_EOL;

try {
    define('LARAVEL_START', microtime(true));

    $basePath = dirname(__DIR__);

    if (!is_file($basePath . '/vendor/autoload.php')) {
        $basePath .= '/precalificacion';
    }

    require $basePath . '/vendor/autoload.php';

    $app = require_once $basePath . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    // echo 'Laravel iniciado correctamente.' . PHP_EOL;

    if (PHP_SAPI !== 'cli') {
        $tokenConfigurado = config('services.seminarios_cron.token');

        if (!is_string($tokenConfigurado) || $tokenConfigurado === '') {
            http_response_code(503);
            echo 'Error: configura SEMINARIOS_CRON_TOKEN en el archivo .env.' . PHP_EOL;
            exit;
        }

        $tokenRecibido = $_GET['token'] ?? '';

        if (!is_string($tokenRecibido) || !hash_equals($tokenConfigurado, $tokenRecibido)) {
            http_response_code(403);
            echo 'Error: token incorrecto.' . PHP_EOL;
            exit;
        }
    }

    Illuminate\Support\Facades\DB::connection()->getPdo();
    echo 'Conexión a la base de datos: correcta.' . PHP_EOL;

    $fechaActual = Illuminate\Support\Carbon::now()->toDateString();
    $consulta = App\Models\Seminario::query()
        ->where('estatus', 'publicado')
        ->where('activo', true)
        ->whereDate('fecha', '<', $fechaActual);

    $encontrados = (clone $consulta)->count();
    $actualizados = $consulta->update(['estatus' => 'finalizado']);

    echo "Seminarios vencidos encontrados: {$encontrados}." . PHP_EOL;
    echo "Seminarios finalizados: {$actualizados}." . PHP_EOL;
} catch (Throwable $error) {
    http_response_code(500);
    echo 'Error: ' . $error->getMessage() . PHP_EOL;
}
