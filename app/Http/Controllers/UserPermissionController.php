<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\PermissionRegistrar;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // code...
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function agrega_permiso($id_permiso, $id_usuario)
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $usuario = User::findOrFail($id_usuario);
        $permiso = Permission::findOrFail($id_permiso);
        
        $usuario->givePermissionTo($permiso);

        return response()->json(['message' => 'Permiso asignado correctamente']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function elimina_permiso($id_permiso, $id_usuario)
    {
        $usuario = User::findOrFail($id_usuario);
        $permiso = Permission::findOrFail($id_permiso);

        // El método revokePermissionTo espera el nombre del permiso
        $usuario->revokePermissionTo($permiso->name);

        return response()->json(['message' => 'Permiso eliminado correctamente'], 200);
    }

}
