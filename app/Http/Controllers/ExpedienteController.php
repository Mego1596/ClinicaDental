<?php

namespace App\Http\Controllers;

use App\Expediente;
use App\Procedimiento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Persona;
use Caffeinated\Shinobi\Models\Role;
use App\User;
use Mail;
class ExpedienteController extends Controller
{

    public function generadorExpediente($request):string
    {
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
                    return $expediente."00".strval($correlativo+1)."-".$anio;
                }elseif ( $correlativo <= 99 ) {
                    return $expediente."0".strval($correlativo+1)."-".$anio;
                }else{
                    return $expediente.strval($correlativo+1)."-".$anio;
                }
            }
        }else{
            return $expediente."001-".$anio;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expedientes = Expediente::all();
        $procedimientos = Procedimiento::all();
        return view('expedientes.index',compact('expedientes','procedimientos'));
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
        $password=substr(md5(microtime()),1,6);
        $user = null;
        $regex = ['required', 'regex:/^(2|7|6)+\d{3}-\d{4}$/'];
        if($request->especial == 'especial'){
            $request->validate([
                'direccion'         =>  'required',
                'fecha_nacimiento'  =>  'required|date|before:'.Carbon::now()->subYears(1)->format('d-m-Y'),
                'sexo'              =>  'required|string',
                'ocupacion'         =>  'required|string',
            ]); 
            $persona                = Persona::find($request->persona);
            $persona->direccion     = $request->direccion;
            $request->request->add(['primer_apellido' => $persona->primer_apellido ]);
            $numero = $this->generadorExpediente($request);
            if(!empty($request->email)){
                $user = new User;
                $user->name     = $numero;
                $user->email    = $request->email;
                $user->password = bcrypt($password);
                $user->save();
                $rol            = Role::where('slug','paciente')->get();
                $user->roles()->sync($rol[0]['id']);
            }
            
        }else{
            $request->validate([
                'primer_nombre'     =>  'required',
                'primer_apellido'   =>  'required',
                'direccion'         =>  'required',
                'telefono'          =>   $regex,
                'fecha_nacimiento'  =>  'required|date|before:'.Carbon::now()->subYears(1)->format('d-m-Y'),
                'sexo'              =>  'required|string',
                'ocupacion'         =>  'required|string',
            ]); 
            $numero = $this->generadorExpediente($request);
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
        }
        $persona->save();
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
        return view('expedientes.show_expediente',compact('expediente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expediente  $expediente
     * @return \Illuminate\Http\Response
     */
    public function edit(Expediente $expediente)
    {
        return view('expedientes.edit_expediente',compact('expediente'));
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
        $regex = ['required', 'regex:/^(2|7|6)+\d{3}-\d{4}$/'];
        $request->validate([
            'primer_nombre'     =>  'required',
            'primer_apellido'   =>  'required',
            'direccion'         =>  'required',
            'telefono'          =>   $regex,
            'fecha_nacimiento'  =>  'required|date|before:'.Carbon::now()->subYears(1)->format('d-m-Y'),
            'sexo'              =>  'required|string',
            'ocupacion'         =>  'required|string',
        ]);

        $password=substr(md5(microtime()),1,6);
        $user = null;
        //VALIDACION EMAIL REPETIDO O CREACION DE USUARIO
        /*comprobacion de que se haya llenado el campo email*/
        if(!empty($request->email)){
            /*comprobacion de que el expediente de la persona tenga un usuario*/
            if (!is_null($expediente->persona->user)) {
                /*comprobacion de que el email del usuario de la persona sea diferente a lo que esta en la vista*/
                if($expediente->persona->user->email != $request->email){
                    $validarEmail = User::where('email',$request->email)->get();
                    if(sizeof($validarEmail) == 0){
                        $expediente->persona->user->email = $request->email;
                        $expediente->persona->user->save();
                    }else{
                        return back()->with('danger','Error, El campo email ya está en uso');
                    }
                }
            }else{
                $user           =   new User;
                $user->name     =   $expediente->numero_expediente;
                $validarEmail = User::where('email',$request->email)->get();
                if(sizeof($validarEmail) == 0){
                    $user->email = $request->email;
                }else{
                    return back()->with('danger','Error, El campo email ya está en uso');
                }
                $user->password = bcrypt($password);
                $user->save();
                $rol            = Role::where('slug','paciente')->get();
                $user->roles()->sync($rol[0]['id']);
            }
        }else{
            /*
              comprobacion de que la persona no tenga un usuario previamente debido al campo email vacio
              que puede simbolizar que nunca lo tuvo en el caso que si lo tenia se elimina el usuario de
              de lo contrario posteriormente se le sigue asignando el valor null a la llave foranea
            */
            if (!is_null($expediente->persona->user)) {
                $expediente->persona->user->delete();
            }
        }
        
        $expediente->persona->primer_nombre      = $request->primer_nombre;
        $expediente->persona->primer_apellido    = $request->primer_apellido;
        $expediente->persona->segundo_nombre     = $request->segundo_nombre;
        $expediente->persona->segundo_apellido   = $request->segundo_apellido;
        $expediente->persona->direccion          = $request->direccion;
        $expediente->persona->telefono           = $request->telefono;
        if(!is_null($user)){
            $expediente->persona->user_id        = $user->id;
            $persona                             = $expediente->persona;
            Mail::send('email.user',['user'=> $user,'password'=>$password], function($m) use($user,$persona){
                $m->to($user->email,$persona->primer_nombre." ".$persona->primer_apellido);
                $m->subject('Contraseña y nombre de usuario');
                $m->from('clinicayekixpaki@gmail.com','Sana Dental');
            });
        }else{
            $expediente->persona->user_id        = null;      
        }
        $expediente->persona->save();
        
        $expediente->sexo                   =   $request->sexo;
        $expediente->ocupacion              =   $request->ocupacion;
        $expediente->fecha_nacimiento       =   $request->fecha_nacimiento;
        $expediente->direccion_trabajo      =   $request->direccion_trabajo;
        $expediente->responsable            =   $request->responsable;
        $expediente->recomendado            =   $request->recomendado;
        $expediente->historia_odontologica  =   $request->historia_odontologica;
        $expediente->historia_medica        =   $request->historia_medica;
        $expediente->save();
        return redirect()->route('expedientes.index')->with('success','El paciente se actualizó con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expediente  $expediente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expediente $expediente)
    {
        /*FALTA VALIDACION DE COMPROBACION DE CITA PARA BORRAR POR COMPLETO*/
        $expediente->persona->user->delete();
        $expediente->persona->delete();
        return back()->with('success','Paciente eliminado con exito');
    }

    public function expediente_especial(){
        return view('create_expediente_especial');
    }
}
