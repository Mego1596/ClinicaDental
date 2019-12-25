<?php

namespace App\Http\Controllers;

use App\Cita;
use Illuminate\Http\Request;
use App\Persona;
use App\Expediente;
use App\Procedimiento;
use Calendar;
use Carbon\Carbon;

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
            'procedimiento'         => 'required'
        ]);
        

        $expediente = Expediente::where('numero_expediente','=',$request->numero_expediente)->first();

        if(isset($expediente)){
            $persona=$expediente->persona;
            $cita = new Cita();
            $cita->fecha_hora_inicio = $request->fecha_hora_inicio;
            $cita->fecha_hora_fin = $request->fecha_hora_fin;
            $cita->procedimiento_id = $request->procedimiento;
            $cita->descripcion = $request->descripcion;
            $cita->persona_id = $persona->id;

            $msj=Cita::esValida($cita);

            if($msj == null){
                if ($cita->save()){
                    $msj_type = 'success';
                    $msj = 'La cita ha sido guardada exitosamente';
               
                }else{ 
                    $msj_type = 'danger';
                }
           
            }else{
                $msj_type = 'danger';
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cita $cita)
    {
        //
    }
}
