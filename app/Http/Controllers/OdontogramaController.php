<?php

namespace App\Http\Controllers;

use App\Odontograma;
use App\Expediente;
use App\Cita;
use Illuminate\Http\Request;

class OdontogramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inicial(Expediente $expediente)
    {   
        $contador = 0;
        if(sizeof($expediente->odontogramas) != 0){
            foreach ($expediente->odontogramas as $odontograma) {
                if($odontograma->activo == 1){
                    $contador++;
                    break;
                }
            }
        }
        if($contador == 0){
            return view('odontogramas.inicial',compact('expediente'));  
        }else{
            return redirect()->back()->with('danger','Error, ya existe un odontograma no puede ingresar.'); 
        }
    }

    public function tratamiento(Cita $cita)
    {   
        $planes_tratamiento   =   Cita::where('reprogramado',0)->whereNull('cita_id')->where('persona_id',$cita->persona_id)->get();
        if(count($planes_tratamiento) == 1){
            if(isset($cita->persona->expediente->odontogramas)){
                foreach ($cita->persona->expediente->odontogramas as $key => $odontograma) {
                    $img = $odontograma->odontograma;
                }
            }
        }else{
            foreach ($planes_tratamiento as $key => $plan_actual) {
                if($key == count($planes_tratamiento)-2){
                    foreach ($plan_actual->odontogramas as $key => $odontograma) {
                        $img = $odontograma->odontograma;
                    }
                }
            }   
        }
        
        $contador = 0;
        if(sizeof($cita->odontogramas) != 0){
            foreach ($cita->odontogramas as $odontograma) {
                if($odontograma->activo == 1){
                    $contador++;
                    break;
                }
            }
        }
        if($contador == 0){
            return view('odontogramas.tratamiento',compact('cita','img'));
        }else{
            return redirect()->back()->with('danger','Error, ya existe un odontograma no puede ingresar.'); 
        }
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

        $odontograma    =   new Odontograma();
        if($request->procedencia == 'Inicial'){
            $expediente                 =   Expediente::find($request->parametro);
            if(isset($expediente)){
                $odontograma->odontograma   =   $request->data_odontograma;
                $odontograma->expediente_id =   $expediente->id;
                $odontograma->tipo          =   $request->procedencia;
                $odontograma->activo        =   1;
                $odontograma->save();
                return redirect()->route('expedientes.show',['expediente' => $expediente->id])->with('success','Odontograma creado con exito');
            }   
        }else if($request->procedencia == 'Tratamiento'){
            $cita                 =   Cita::find($request->parametro);
            $planes_tratamiento   =   Cita::where('reprogramado',0)->whereNull('cita_id')->where('persona_id',$cita->persona_id)->latest()->get();
            if(isset($cita)){
                $odontograma->odontograma   =   $request->data_odontograma;
                $odontograma->cita_id       =   $cita->id;
                $odontograma->tipo          =   $request->procedencia;
                $odontograma->activo        =   1;
                $odontograma->save();
                return redirect()->route('expedientes.planes',['cita' => $cita->persona->id])->with('success','Odontograma creado con exito');
            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Odontograma  $odontograma
     * @return \Illuminate\Http\Response
     */
    public function show(Odontograma $odontograma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Odontograma  $odontograma
     * @return \Illuminate\Http\Response
     */
    public function edit(Odontograma $odontograma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Odontograma  $odontograma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Odontograma $odontograma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Odontograma  $odontograma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Odontograma $odontograma)
    {
        $odontograma->activo = 0;
        $odontograma->save();
        return redirect()->back()->with('success','Odontograma eliminado con exito');
    }
}
