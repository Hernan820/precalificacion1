<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function vistaproceso(){
        return view('welcome');
    }

    public function vistaDataFormularios(){

        // muestra usuarios sin permiso
        $usuarios_permiso = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('model_has_permissions', function ($join) {
                $join->on('users.id', '=', 'model_has_permissions.model_id')
                    ->where('model_has_permissions.model_type', '=', 'App\\Models\\User');
            })
            ->whereIn('model_has_roles.role_id', [1,2])
            ->where('users.estado_user', '=', 1)
            ->select(
                'users.id',
                'users.name',
                DB::raw('MAX(CASE WHEN model_has_permissions.permission_id = 1 THEN 1 ELSE 0 END) as permiso_guipdf'),
                DB::raw('MAX(CASE WHEN model_has_permissions.permission_id = 2 THEN 1 ELSE 0 END) as permiso_cliente')
            )
            ->groupBy('users.id', 'users.name')
            ->get();

        Log::info("muestra usuarios sin permiso");
        Log::info(print_r($usuarios_permiso->toJson(JSON_PRETTY_PRINT), true));

        return view('manager',[
            'usuarios_permiso' => $usuarios_permiso,
        ]);
    }
    /**
     * 
     * 
     */
    public function vista_user(){ 
        return view('auth.registro_usuarios');
    }
}
