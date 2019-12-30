<?php

namespace App\Http\Controllers;

use App\Pago;
use App\Cita;
use Illuminate\Http\Request;
use App\User;
use DB;
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
        })->select('users.id','personas.primer_nombre','personas.segundo_nombre','personas.primer_apellido','personas.segundo_apellido')->get();
        
        $total = Pago::total_plan($cita);
        return view('pagos.index',compact('cita','users','total'));
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
        if(!isset($cita->pago)){
            $total = Pago::total_plan($cita);
            $request->validate([
                'abono'             => 'required|numeric|min:0|lte:'.$total,
                'user'              => 'required'
            ]);
            $pago = new Pago();
            $pago->abono        = $request->abono;
            $pago->cita_id      = $cita->id;
            $pago->user_id      = $request->user;
            if ($pago->save()) {
                $msj_type = 'success';
                $msj = "pago registrado exitosamente";
            }else{
                $msj_type = 'danger';
                $msj = "el pago no pudo registrarse algo salió mal";            
            }
        }else{
            $msj_type   = 'danger';
            $msj        = 'Error, esta cita ya se encuentra pagada';
        }

        return redirect()->back()->with($msj_type,$msj);
        
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
    public function update(Request $request,Cita $cita, Pago $pago)
    {   
        if($cita->pago->id == $pago->id){
            $total = Pago::total_plan($cita)+$pago->abono;
            $request->validate([
                'abono'             => 'required|numeric|min:0|lte:'.$total,
                'user'              => 'required'
            ]);

            $pago->abono        = $request->abono;
            $pago->cita_id      = $cita->id;
            $pago->user_id      = $request->user;
            if ($pago->save()) {
                $msj_type = 'success';
                $msj = "El pago se actualizó con exito";
            }else{
                $msj_type = 'danger';
                $msj = "el pago no pudo registrarse algo salió mal";            
            }
            
        }else{
            $msj_type = 'danger';
            $msj = 'Este pago no corresponde a la cita actual';
        }
        return redirect()->back()->with($msj_type,$msj);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pago $pago,Cita $cita)
    {
        
    }
}
