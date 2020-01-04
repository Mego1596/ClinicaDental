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
    public function tratamiento(Cita $cita)
    {
        $ultimo_odontograma = Cita::join('odontogramas as o','o.cita_id','=','citas.id')->where('citas.reprogramado',false)->whereNull('citas.cita_id')->where('o.cita_id','<',$cita->id)->where('citas.persona_id',$cita->persona_id)->select('o.*')->latest()->take(1)->get();
        if(sizeof($ultimo_odontograma) == 0){
            $img = asset('img/odontograma.png');    
        }else{        
            $img = $ultimo_odontograma[0]->odontograma;
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
        $cita           =   Cita::find($request->parametro);
        $ultimo_plan    =   Cita::where('reprogramado',false)->whereNull('cita_id')->where('persona_id',$cita->persona_id)->latest()->first();
        if($ultimo_plan->id == $request->parametro){
            $planes_tratamiento     =   Cita::where('reprogramado',false)->whereNull('cita_id')->where('persona_id',$cita->persona_id)->latest()->get();
            if(isset($cita)){
                $odontograma->odontograma   =   $request->data_odontograma;
                $odontograma->cita_id       =   $cita->id;
                $odontograma->activo        =   1;
                $odontograma->save();
                return redirect()->route('expedientes.planes',['persona' => $cita->persona->id])->with('success','Odontograma creado con exito');
            }
        }else{
            return redirect()->route('expedientes.planes',['persona' => $ultimo_plan->persona->id])->with('danger','Error, este no es el ultimo plan de tratamiento');
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
