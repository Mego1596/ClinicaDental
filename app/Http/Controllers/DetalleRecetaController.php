<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetalleReceta;
use App\Receta;

class DetalleRecetaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Receta $receta)
    {
        if(sizeof($receta->detalle_receta) < 2){
            $request->validate([
                'medicamento'       => 'required',
                'dosis'             => 'required',
                'cantidad'          => 'required',
            ]);

            $detalle                =   new DetalleReceta;
            $detalle->medicamento   =   $request->medicamento;
            $detalle->dosis         =   $request->dosis;
            $detalle->cantidad      =   $request->cantidad;
            $detalle->receta_id     =   $receta->id;
            $detalle->save();
            return back()->with('success','Detalle añadido con exito'); 
        }else{
            return back()->with('danger','Error, La receta tiene el máximo de detalles permitidos por receta');
        }
        


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetalleReceta  $detalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta, DetalleReceta $detalle )
    {
        if($receta->id == $detalle->receta->id){
            $request->validate([
                'medicamento'       => 'required',
                'dosis'             => 'required',
                'cantidad'          => 'required',
            ]);
            $detalle->medicamento   =   $request->medicamento;
            $detalle->dosis         =   $request->dosis;
            $detalle->cantidad      =   $request->cantidad;
            $detalle->save(); 
            return back()->with('success','El detalle de la receta se actualizo correctamente');
        }else{
            return back()->with('danger','Error, El detalle de la receta no pertenece a la receta actual');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetalleReceta  $detalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta,DetalleReceta $detalle)
    {

        $contador_coincidencias = 0;
        foreach ($receta->detalle_receta as $datos) {
            if($datos->id == $detalle->id){
                $contador_coincidencias++;
            }
        }
        if($contador_coincidencias != 0){
            $detalle->delete();
            return back()->with('success','Detalle eliminado con exito');
        }else{
            return back()->with('danger','Error, El detalle de la receta no pertenece a la receta actual');
        }
    }
}
