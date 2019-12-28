<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Cita;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PersonaController extends Controller
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
    {   $telefono_regex = ['required', 'regex:/^(2|7|6)+\d{3}-\d{4}$/'];
        $request->validate([
            'primer_nombre'     =>  'required',
            'primer_apellido'   =>  'required',
            'telefono'          =>   $telefono_regex,
            'fecha_hora_inicio'     => 'required|after:'.Carbon::now()->subDays(1)->format('d-m-Y'),
            'fecha_hora_fin'        => 'required|after:fecha_hora_inicio',
        ]);


        $persona = new Persona();
        $persona->primer_nombre      = $request->primer_nombre;
        $persona->primer_apellido    = $request->primer_apellido;
        $persona->segundo_nombre     = $request->segundo_nombre;
        $persona->segundo_apellido   = $request->segundo_apellido;
        $persona->telefono           = $request->telefono;

        $cita = new Cita();
        $cita->fecha_hora_inicio    = $request->fecha_hora_inicio;
        $cita->fecha_hora_fin       = $request->fecha_hora_fin;
        $cita->descripcion          = $request->descripcion;
            
        $msj = Cita::esValida($cita); 
        if($msj == null){
            if($persona->save()){
                $cita->persona_id = $persona->id;
                if($cita->save()){
                    if(!is_null($cita->procedimiento)){
                        foreach (array_unique($request->procedimiento) as $procedimiento) {
                           $cita->procedimientos()->attach($procedimiento);
                        }
                    }else{
                        $cita->procedimientos()->where('cita_id',$cita->id)->sync($request->procedimiento); 
                    }
                    return redirect()->route('home')->with('success','La cita se registró exitosamente');
                }else{
                    return redirect()->route('home')->with('danger','La persona no pudo ser registrada');
                }
            }
        }else{
            $msj_type = 'danger';     
        }     
        return redirect()->route('home')->with($msj_type,$msj);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        //
    }
}
