<?php

namespace App\Http\Controllers;

use App\Pago;
use App\Cita;
use Illuminate\Http\Request;
use App\User;
class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cita $cita)
    {
        $users = User::join('role_user','role_user.user_id','=','users.id')->join('roles','roles.id','=','role_user.role_id')->join('personas','personas.user_id','=','users.id')->where(function($query){
            $query->where('roles.slug','admin');
            $query->orWhere('roles.slug','doctor');
        })->get();
        return view('pagos.index',compact('cita','users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Cita $cita)
    {
        return view('pagos.create_pago',compact('cita'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Cita $cita)
    {
        $pago = new Pago();
        $pago->total_cita = $request->total_cita;
        $pago->abono = $request->abono;
        $pago->diferencia = $request->total_cita - $request->abono;
        $pago->cita_id = $cita->id;

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
