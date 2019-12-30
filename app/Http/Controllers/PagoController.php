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
        
        $total = $this->total_plan($cita);
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
        $total = $this->total_plan($cita);
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
            $total = $this->total_plan($cita)+$pago->abono;
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

    public function honorarios(Cita $cita):float{
        $total = 0.0;
        foreach ($cita->procedimientos as $procedimiento_actual) {
            $stringSQL                                      =   "SELECT honorarios,numero_piezas FROM procedimiento_citas 
                                                            WHERE cita_id=".$procedimiento_actual->pivot->cita_id.
                                                            " AND procedimiento_id =".$procedimiento_actual->pivot->procedimiento_id;
            $resultado                                      =   DB::select(DB::raw($stringSQL));
            $total                                         +=   $resultado[0]->honorarios;
        }
        return $total;
    }

    public function total_plan(Cita $cita):float{
        $total          = 0.0;
        $total_padre    = 0.0;
        $total_hijos    = 0.0;
        $total_abonos   = 0.0;
        if(isset($cita->cita_id)){
            $cita_padre  = Cita::where('reprogramado',0)->whereNull('cita_id')->where('id',$cita->cita_id)->get();
            $citas_hijas = Cita::where('reprogramado',0)->where('cita_id', $cita->cita_id)->get();
            if(isset($cita_padre[0]->procedimientos)){
                $total_padre        = $this->honorarios($cita_padre[0]);
            }
            if(isset($cita_padre[0]->pago)){
                    $total_abonos  +=   $cita_padre[0]->pago->abono;
            }
            foreach ($citas_hijas as $cita_actual) {
                if(isset($cita_actual->procedimientos)){
                    $total_hijos    = $this->honorarios($cita_actual);
                }
                if(isset($cita_actual->pago)){
                    $total_abonos  +=   $cita_actual->pago->abono;
                }
            }
        }else{
            $citas_hijas = Cita::where('reprogramado',0)->where('cita_id', $cita->id)->get();
            if(isset($cita->procedimientos)){
                $total_padre     = $this->honorarios($cita);
                if(isset($cita->pago)){
                    $total_abonos  +=   $cita->pago->abono;
                }
            }
            foreach ($citas_hijas as $cita_actual) {
                if(isset($cita_actual->procedimientos)){
                    $total_hijos    = $this->honorarios($cita_actual);
                }
                if(isset($cita_actual->pago)){
                    $total_abonos  +=   $cita_actual->pago->abono;
                }
            }
        }
        return $total = ($total_padre + $total_hijos) - $total_abonos;
    }
}
