<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;


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
        $request->validate([
            'selectUsuariosAsignado' => 'required|exists:users,id',
            'permisos_usuarios' => 'required|array',
        ]);

        foreach ($request->permisos_usuarios as $permiso) {
            if ($permiso == "gestion") {
                $usuario = User::findOrFail($request->selectUsuariosAsignado);
                $usuario->givePermissionTo("guia_pdf"); 
            }else if ($permiso == "creador") {
                $usuario = User::findOrFail($request->selectUsuariosAsignado);
                $usuario->givePermissionTo("registro_clientes"); 
            }
        }

        return response()->json(['message' => 'Permiso asignado correctamente']);
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
    public function edit($id, Request $request )
    {
        $usuario = User::findOrFail($id);

        if ($request->permiso == 3) {
            if (Permission::where('name', 'guia_pdf')->exists()) {
                $usuario->givePermissionTo("guia_pdf");
            } else {
                Log::warning("El permiso 'guia_pdf' no existe.");
            }
        } 
        
        if ($request->permiso == 2) {
            if (Permission::where('name', 'registro_clientes')->exists()) {
                $usuario->givePermissionTo("registro_clientes");
            } else {
                Log::warning("El permiso 'registro_clientes' no existe.");
            }
        }

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
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->syncPermissions([]);

        return response()->json($usuario, 200);
    }
}
