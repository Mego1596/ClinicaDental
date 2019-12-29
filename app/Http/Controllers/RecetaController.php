<?php

namespace App\Http\Controllers;

use App\Receta;
use App\Cita;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use App\DetalleReceta;
class RecetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cita $cita)
    {
        return view('recetas.index',compact('cita'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Cita $cita)
    {
        $request->validate([
            'peso'     => 'required|numeric',
        ]);
        $receta             =   new Receta;
        $receta->peso       =   $request->peso;
        $receta->cita_id    =   $cita->id;
        $receta->save();
        return redirect()->back()->with('success','Receta añadida con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cita  $cita
     * @return \Illuminate\Http\Response
     */
    public function show(Cita $cita,Receta $receta)
    {
        if($cita->receta->id == $receta->id){
            $edad= Carbon::parse($cita->persona->expediente->fecha_nacimiento)->age;
            $fecha = substr($receta->created_at, 0,11);
            $newDate = date("d/m/Y", strtotime($fecha));
            $detalles = $receta->detalle_receta;
            $pdf = PDF::loadView('recetas.show_receta',compact('cita','receta','newDate','detalles','edad'));
            $pdf->setPaper('A4','Portrait');
            return $pdf->stream();
        }else{
            $msj_type   = 'danger';
            $msj        = 'Error, la receta no se asigno en esta cita';
        }
        return redirect()->back()->with($msj_type,$msj);
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Cita $cita, Receta $receta)
    {
        if($cita->receta->id == $receta->id){
            $request->validate([
                'peso'     => 'required|numeric',
            ]);
            $receta->peso       =   $request->peso;
            $receta->save();
            return redirect()->back()->with('success','La receta se actulizó con exito'); 
        }else{
            return redirect()->back()->with('danger','Error esta receta no corresponde a la cita actual');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cita $cita,Receta $receta)
    {
        if($cita->receta->id == $receta->id){
            $receta->delete();
            return back()->with('success','Receta eliminada con exito');
        }else{
            return back()->with('danger','Error, La receta no pertenece a la cita actual');
        }
    }
}
