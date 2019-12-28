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

class CitaController extends Controller
{


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
            'fecha_hora_inicio'     => 'required|after:'.Carbon::now()->subDays(1)->format('d-m-Y'),
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
                    if(!is_null($cita->procedimiento)){
                        foreach (array_unique($request->procedimiento) as $procedimiento) {
                           $cita->procedimientos()->attach($procedimiento);
                        }
                    }else{
                        $cita->procedimientos()->where('cita_id',$cita->id)->sync($request->procedimiento); 
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
            if(!is_null($cita->procedimiento)){
                $cita->procedimientos()->where('cita_id',$cita->id)->sync(array_unique($request->procedimiento)); 
            }else{
                $cita->procedimientos()->where('cita_id',$cita->id)->sync($request->procedimiento); 
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
            'fecha_hora_inicio'     => 'required|after:'.Carbon::now()->subDays(1)->format('d-m-Y'),
            'fecha_hora_fin'        => 'required|after:fecha_hora_inicio',
        ]);
        
        
        $new_cita = new Cita();
        $new_cita->fecha_hora_inicio = $request->fecha_hora_inicio;
        $new_cita->fecha_hora_fin = $request->fecha_hora_fin;
        $new_cita->descripcion = $cita->descripcion;
        $new_cita->persona_id = $cita->persona_id;
        
        $msj_type = 'danger';
        $msj = Cita::esValida($new_cita);

        if($msj==null){
            if($new_cita->save()){
                $new_cita->procedimientos()->sync($cita->procedimientos);
                $cita->reprogramado = 1;
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

        return redirect()->route('home')->with($msj_type,$msj);
    }
}
