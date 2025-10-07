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

      app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();


        $usuarios = DB::table('users as u')
          ->join('model_has_roles as mhr', 'u.id', '=', 'mhr.model_id')
          ->where('u.estado_user', 1)
          ->whereIn('mhr.role_id', [2])
          ->groupBy('u.id', 'u.name')
          ->orderBy('u.name')
          ->selectRaw("
            u.id,
            u.name as nombre_usuario,

            COALESCE((
              SELECT GROUP_CONCAT(CONCAT(p.id, '|', p.name) ORDER BY p.name SEPARATOR ',')
              FROM permissions p
              JOIN model_has_permissions mhp2
                ON mhp2.permission_id = p.id
              AND mhp2.model_type = 'App\\\\Models\\\\User'
              WHERE mhp2.model_id = u.id
              -- AND p.guard_name = 'web'
            ), '') as permisos_asignados,

            COALESCE((
              SELECT GROUP_CONCAT(CONCAT(p2.id, '|', p2.name) ORDER BY p2.name SEPARATOR ',')
              FROM permissions p2
              WHERE p2.id NOT IN (
                SELECT permission_id
                FROM model_has_permissions
                WHERE model_id = u.id
                  AND model_type = 'App\\\\Models\\\\User'
              )
              -- AND p2.guard_name = 'web'
            ), '') as permisos_no_asignados
          ")
          ->get();

        // Log::info("muestra usuarios sin permiso");
        // Log::info(print_r($usuarios->toJson(JSON_PRETTY_PRINT), true));

        return view('manager',[
            'usuarios_permiso' => $usuarios,
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
