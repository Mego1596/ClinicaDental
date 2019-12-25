<?php

namespace App\Http\Controllers;

use App\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pagos.create_pago');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pago = new Pago();
        $pago->total_cita = $request->total_cita;
        $pago->abono = $request->abono;
        $pago->diferencia = $request->total_cita - $request->abono;
        $pago->cita_id = $request->cita;

        if ($pago->save()) {
            $msj_type = 'success';
            $msj = "pago registrado exitosamente";
        }else{
            $msj_type = 'danger';
            $msj = "el pago no pudo registrarse algo salió mal";            
        }
        return redirect()->action('CitaController@show',['cita' => $request->cita])->with($msj_type,$msj);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(Pago $pago)
    {
        return view('pagos.show_pago',compact('pago'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function edit(Pago $pago)
    {
        return view('pagos.edit_pago',compact('pago'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pago $pago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pago $pago)
    {
        //
    }
}
