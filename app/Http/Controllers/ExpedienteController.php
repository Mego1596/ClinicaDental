<?php

namespace App\Http\Controllers;

use App\Expediente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Persona;
use Caffeinated\Shinobi\Models\Role;
use App\User;
use Mail;
class ExpedienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expedientes = Expediente::all();
        return view('expedientes.index',compact('expedientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expedientes.create_expediente');
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
            'primer_nombre'     =>  'required',
            'primer_apellido'   =>  'required',
            'direccion'         =>  'required',
            'telefono'          =>  'required|regex:/^\d{4}-\d{4}$/',
            'fecha_nacimiento'  =>  'required|date|before:'.Carbon::now()->subYears(1)->format('d-m-Y'),
            'sexo'            =>  'required|string',
            'ocupacion'         =>  'required|string',
        ]);


        $anio = Carbon::now()->year;
        $expediente = $request->primer_apellido[0];
        $busquedaExpediente = $expediente.'%'.$anio;
        $string = "SELECT numero_expediente FROM expedientes 
        WHERE numero_expediente LIKE '".$busquedaExpediente."' AND id IN 
        (SELECT MAX(id) FROM expedientes 
            WHERE numero_expediente LIKE '".$busquedaExpediente.
        "')";
        $query                           = DB::select( DB::raw($string));

        if($query != NULL)
        {
            foreach ($query as $key => $value) {
                $correlativo = (int)substr($value->numero_expediente,1,3);
                if( $correlativo <= 9 ){
                    $numero = $expediente."00".strval($correlativo+1)."-".$anio;
                }elseif ( $correlativo <= 99 ) {
                    $numero = $expediente."0".strval($correlativo+1)."-".$anio;
                }else{
                    $numero = $expediente.strval($correlativo+1)."-".$anio;
                }
            }
        }else{
            $numero = $expediente."001-".$anio;
        }
        $password=substr(md5(microtime()),1,6);
        $user = null;
        if(!empty($request->email)){
            $user = new User;
            $user->name     = $numero;
            $user->email    = $request->email;
            $user->password = bcrypt($password);
            $user->save();
            $rol            = Role::where('slug','paciente')->get();
            $user->roles()->sync($rol[0]['id']);
        }
        
        $persona = new Persona;
        $persona->primer_nombre      = $request->primer_nombre;
        $persona->primer_apellido    = $request->primer_apellido;
        $persona->segundo_nombre     = $request->segundo_nombre;
        $persona->segundo_apellido   = $request->segundo_apellido;
        $persona->direccion          = $request->direccion;
        $persona->telefono           = $request->telefono;
        if(!is_null($user)){
            $persona->user_id        = $user->id;
            Mail::send('email.user',['user'=> $user,'password'=>$password], function($m) use($user,$persona){
                $m->to($user->email,$persona->primer_nombre." ".$persona->primer_apellido);
                $m->subject('Contraseña y nombre de usuario');
                $m->from('clinicayekixpaki@gmail.com','Sana Dental');
            });
        }else{
            $persona->user_id        = $user;      
        }
        $persona->save();
        $expediente = new Expediente;
        $expediente->numero_expediente      =   $numero;
        $expediente->sexo                   =   $request->sexo;
        $expediente->ocupacion              =   $request->ocupacion;
        $expediente->fecha_nacimiento       =   $request->fecha_nacimiento;
        $expediente->direccion_trabajo      =   $request->direccion_trabajo;
        $expediente->responsable            =   $request->responsable;
        $expediente->recomendado            =   $request->recomendado;
        $expediente->historia_odontologica  =   $request->historia_odontologica;
        $expediente->historia_medica        =   $request->historia_medica;
        $expediente->persona_id             =   $persona->id;
        $expediente->save();
        return redirect()->route('expedientes.index')->with('success','Paciente añadido con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expediente  $expediente
     * @return \Illuminate\Http\Response
     */
    public function show(Expediente $expediente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expediente  $expediente
     * @return \Illuminate\Http\Response
     */
    public function edit(Expediente $expediente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expediente  $expediente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expediente $expediente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expediente  $expediente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expediente $expediente)
    {
        //
    }
}
