<?php

namespace App\Http\Controllers;

use App\Cita;
use Illuminate\Http\Request;
use App\Persona;
use App\Expediente;
use App\Procedimiento;
use Calendar;
use Carbon\Carbon;
use DateTime;
use DB;
class CitaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('citas.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $procedimientos = Procedimiento::all();
        return view('citas.create_cita',compact('procedimientos'));
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
            'numero_expediente'     =>'required',
            'fecha_hora_inicio'     => 'required|after:'.Carbon::now()->format('d-m-Y'),
            'fecha_hora_fin'        => 'required|after:fecha_hora_inicio',
        ]);
        

        $expediente = Expediente::where('numero_expediente','=',$request->numero_expediente)->first();

        if(isset($expediente)){
            $persona = $expediente->persona;
            $cita                       = new Cita();
            $cita->fecha_hora_inicio    = $request->fecha_hora_inicio;
            $cita->fecha_hora_fin       = $request->fecha_hora_fin;
            $cita->descripcion          = $request->descripcion;
            $cita->persona_id           = $persona->id;

            $msj = Cita::esValida($cita);
            if($msj == null){
                if ($cita->save()){
                    if(!is_null($request->procedimiento)){
                        foreach ($request->procedimiento as $procedimiento) {
                            $cita->procedimientos()->attach($procedimiento['id'],[ 
                                'numero_piezas' => $procedimiento['numero_piezas'], 
                                'honorarios' => $procedimiento['honorarios'] 
                            ]);
                        } 
                    }
                    $msj_type   = 'success';
                    $msj        = 'La cita ha sido añadida exitosamente';
               
                }else{ 
                    $msj_type   = 'danger';
                }
           
            }else{
                $msj_type   = 'danger';
            }
            
            return redirect()->route('home')->with($msj_type,$msj);

        }else{
            return redirect()->route('home')->with('danger','El número de expediente no ha sido encontrado');
        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function show(Cita $cita)
    {
        return view('citas.show_cita',compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function edit(Cita $cita)
    {
        return view('citas.edit_cita',compact('cita'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cita $cita)
    {
        $cita->descripcion          = $request->descripcion;
        if ($cita->save()){
            if(isset($cita->procedimientos)){
                $cita->procedimientos()->where('cita_id',$cita->id)->detach(); 
                if(!is_null($request->procedimiento)){
                    foreach ($request->procedimiento as $procedimiento) {
                        $cita->procedimientos()->attach($procedimiento['id'],[ 
                            'numero_piezas' => $procedimiento['numero_piezas'], 
                            'honorarios' => $procedimiento['honorarios']
                        ]);
                    } 
                }
            }elseif(!is_null($request->procedimiento) ){
                $cita->procedimientos()->where('cita_id',$cita->id)->detach();
                foreach ($request->procedimiento as $procedimiento) {
                    $cita->procedimientos()->attach($procedimiento['id'],[ 
                        'numero_piezas' => $procedimiento['numero_piezas'], 
                        'honorarios' => $procedimiento['honorarios'] 
                    ]);
                } 
            }else{
                $cita->procedimientos()->where('cita_id',$cita->id)->detach(); 
            }
            $msj_type   = 'success';
            $msj        = 'La cita se actualizó exitosamente';
        }else{
            $msj_type   = 'danger';
            $msj        = 'La cita no se pudo actualizar';
        }
        return redirect()->route('home')->with($msj_type,$msj);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cita $cita)
    {
        if(isset($cita->pago)){
            return redirect()->back()->with('danger','Error, la cita se encuentra pagada, no se puede eliminar');
        }
        $actualidad = new DateTime('now');
        $fecha_cita = new DateTime($cita->fecha_hora_inicio);
        if($actualidad<$fecha_cita){

            if($cita->delete()){
                $msj_type = 'success';
                $msj = 'Cita eliminada con éxito';
            }else{
                $msj_type = 'danger';
                $msj = 'La cita no pudo eliminarse';
            }

        }else{
            $msj_type = 'danger';
            $msj = 'La cita ya no puede eliminarse';
        }

        return redirect()->route('home')->with($msj_type,$msj);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function reprogramar(Request $request, Cita $cita){
        $request->validate([
            'fecha_hora_inicio'     => 'required|after:'.Carbon::now()->format('d-m-Y'),
            'fecha_hora_fin'        => 'required|after:fecha_hora_inicio',
        ]);
        if(isset($cita->pago)){
            return redirect()->back()->with('danger','Error, la cita se encuentra pagada, no se puede reprogramar');
        }
        $actualidad = new DateTime('now');
        $fecha_cita = new DateTime($cita->fecha_hora_inicio);
        if($actualidad<$fecha_cita){
            $new_cita = new Cita();
            $new_cita->fecha_hora_inicio    = $request->fecha_hora_inicio;
            $new_cita->fecha_hora_fin       = $request->fecha_hora_fin;
            $new_cita->descripcion          = $cita->descripcion;
            $new_cita->persona_id           = $cita->persona_id;
            if(is_null($cita->cita_id)){
                $new_cita->cita_id          = $cita->id;
            }else{
                $new_cita->cita_id          = $cita->cita_id;
            }
            $msj_type = 'danger';
            $msj = Cita::esValida($new_cita);
            if($msj==null){
                if($new_cita->save()){
                    $array_procedimientos = [];
                    foreach ($cita->procedimientos as $key => $procedimiento_parcial) {
                        $array_procedimientos[]                         =   $procedimiento_parcial;
                        $stringSQL                                      =   "SELECT honorarios,numero_piezas FROM procedimiento_citas 
                                                                            WHERE cita_id=".$procedimiento_parcial->pivot->cita_id.
                                                                            " AND procedimiento_id =".$procedimiento_parcial->pivot->procedimiento_id;
                        $resultado                                      =   DB::select(DB::raw($stringSQL));
                        $array_procedimientos[$key]['numero_piezas']    =   $resultado[0]->numero_piezas;
                        $array_procedimientos[$key]['honorarios']       =   $resultado[0]->honorarios;
                    }
                    if(!empty($array_procedimientos)){
                        foreach ($array_procedimientos as $procedimiento) {
                            $new_cita->procedimientos()->attach($procedimiento['id'],[ 
                                'numero_piezas' => $procedimiento['numero_piezas'], 
                                'honorarios' => $procedimiento['honorarios'] 
                            ]);
                        }  
                    }
                     
                    $cita->reprogramado = true;
                    if($cita->save()){
                        $msj_type = 'success';
                        $msj = 'La cita se reprogramó con éxito';
                    }else{
                        $msj = 'Algo salió mal al registrar la reprogramación';
                    }
                }else{
                    $msj = 'La nueva cita no pudo registrarse';
                }
            }
        }else{
            $msj_type = 'danger';
            $msj = 'La cita ya no puede reprogramarse';
        }
        return redirect()->route('home')->with($msj_type,$msj);
            
    }

    public function seguimiento(Request $request,Cita $cita){
        $request->validate([
            'fecha_hora_inicio'     => 'required|after:'.Carbon::now()->format('d-m-Y'),
            'fecha_hora_fin'        => 'required|after:fecha_hora_inicio',
        ]);
        $new_cita                       = new Cita();
        $new_cita->fecha_hora_inicio    = $request->fecha_hora_inicio;
        $new_cita->fecha_hora_fin       = $request->fecha_hora_fin;
        $new_cita->descripcion          = $request->descripcion;
        $new_cita->persona_id           = $cita->persona_id;
        if(is_null($cita->cita_id)){
            $new_cita->cita_id          = $cita->id;
        }else{
            $new_cita->cita_id          = $cita->cita_id;
        }
        
        $msj = Cita::esValida($new_cita);
        if($msj == null){
            if ($new_cita->save()){
                if(!is_null($request->procedimiento)){
                    foreach ($request->procedimiento as $procedimiento) {
                        $new_cita->procedimientos()->attach($procedimiento['id'],[ 
                            'numero_piezas' => $procedimiento['numero_piezas'], 
                            'honorarios' => $procedimiento['honorarios'] 
                        ]);
                    } 
                }
                $msj_type   = 'success';
                $msj        = 'La cita ha sido añadida exitosamente';
           
            }else{ 
                $msj_type   = 'danger';
            }
       
        }else{
            $msj_type   = 'danger';
        }
        
        return redirect()->route('home')->with($msj_type,$msj);

    }
}
