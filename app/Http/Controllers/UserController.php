<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
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
    public function  create_user(Request $request)
    {
        $usuario= new User;
        $usuario->name     = $request->nombre; 
        $usuario->email    = $request->email;
        $usuario->password = Hash::make($request->contra);
        $usuario->save();
        $usuario->assignRole($request['rol']); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $usuarios = User::join('model_has_roles','model_has_roles.model_id','=','users.id')
        ->join('roles','roles.id','=','model_has_roles.role_id')
        ->select("roles.*","users.*","roles.name as nombre_rol","users.id as userid")
        ->get();

        return (response()->json($usuarios));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuarios = User::join('model_has_roles','model_has_roles.model_id','=','users.id')
        ->join('roles','roles.id','=','model_has_roles.role_id')
        ->select("roles.*","users.*","roles.name as nombre_rol","users.id as userid")
        ->where("users.id","=",$id)
        ->get();
        
        return (response()->json($usuarios));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $role = DB::table('roles') ->join('model_has_roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->select('roles.id', 'roles.name', 'model_has_roles.model_id') 
       ->where('model_id',"=",$request->id_usuarioactualizar) 
       ->get()
       ->first();

       $User= User::find($request->id_usuarioactualizar);
       $User ->name = $request-> nombre;
       $User ->email = $request-> email ;

        if($request->cambiarcontra == "si"){
           $User->password = Hash::make($request->contra);
        }

       $User->save();

        if($request->rol != $role){
            $User->roles()->detach();
            $User->assignRole($request->rol ); 
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
