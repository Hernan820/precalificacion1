<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WpformsController extends Controller
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
        // 0) Autenticación: validar Bearer token del header
        //    (evita depender de ->bearerToken() si tu versión es antigua)
        $authHeader = $request->header('Authorization', '');
        $incoming   = '';
        if (preg_match('/Bearer\s+(.+)/i', $authHeader, $m)) {
            $incoming = trim($m[1]);
        }
        abort_unless($incoming && hash_equals($incoming, env('WPFORMS_TOKEN')), 401, 'Invalid or missing token');


        // ... tu auth y validación básica ...
        $request->validate([
            'entry_id'     => 'required|string|max:100',
            'form_id'      => 'required|integer',
            'form_post_id' => 'nullable|integer',
            'form_date'    => 'nullable|string|max:50',
            'form_value'   => 'required|string', // ← viene serializado
        ]);

        $formValue = $request->input('form_value');              // ← string serializado
        $formDate  = $request->input('form_date', now());        // puedes usar el enviado o now()
        $formPostId= (int) $request->input('form_post_id', 0);


        DB::table('wp_wpforms_db')->insert([
            'form_value'   => $formValue,          // ← sin json_encode
            'form_date'    => is_string($formDate) ? $formDate : now(),
            'form_post_id' => $formPostId,
        ]);

        return response()->json(['ok' => true]);
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
    public function edit($id)
    {
        //
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
        //
    }
}
