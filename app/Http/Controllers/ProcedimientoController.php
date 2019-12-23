<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Procedimiento;
class ProcedimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $procedimientos = Procedimiento::all();
        return view('procedimientos.index',compact('procedimientos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('procedimientos.create_procedimiento');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $procedimiento = new Procedimiento;
        $procedimiento->nombre = $request->nombre;
        $procedimiento->descripcion = $request->descripcion;
        $procedimiento->save();
        return back()->with('success','Procedimiento añadido con exito');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $procedimiento = Procedimiento::find($id);
        $procedimiento->nombre = $request->nombre;
        $procedimiento->descripcion = $request->descripcion;
        $procedimiento->save();
        return back()->with('success','Procedimiento añadido con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $procedimiento = Procedimiento::find($id);
        if($procedimiento->id > 40){
            $procedimiento->delete();
            return back()->with('success','Procedimiento eliminado con exito');
        }else{
            return back()->with('danger','El procedimiento seleccionado no se puede eliminar');
        }
    }
}
