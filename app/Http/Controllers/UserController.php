<?php

namespace App\Http\Controllers;

use App\User;
use App\Persona;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Caffeinated\Shinobi\Models\Role;
use Mail;
use Carbon\Carbon;
use DB;
class UserController extends Controller
{

    public function __construct(){
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        $roles = Role::all();
        return view('usuarios.index',compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id','<>',1)->get();
        return view('usuarios.create_user',compact('roles'));
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
            'primer_nombre' => 'required',
            'primer_apellido' => 'required',
            'email' => 'required|unique:users|regex:/^.+@.+$/i',
            'direccion' => 'required',
            'telefono' => 'required|regex:/^\d{4}-\d{4}$/',
            'role' => 'required'
        ]);
        $password=substr(md5(microtime()),1,6);
        $user                     = new User();
        //LOGICA PARA CREACION DE NOMBRE USUARIOS
        //Verificar que el segundo nombre y segundo apellido no esten vacios
        $anio = Carbon::now()->year;
        $username = $request->primer_nombre[0];
        if(!empty($request->segundo_nombre)){
            $username .= $request->segundo_nombre[0].$request->primer_apellido[0];
        }else{
            $username .= $request->primer_nombre[0].$request->primer_apellido[0];
        }
        if(!empty($request->segundo_apellido)){
            $username .= $request->segundo_apellido[0];
        }else{
            $username .= $request->primer_apellido[0];
        }
        $busquedaUsername = $username.'%'.$anio;
        $string = "SELECT name FROM users 
        WHERE name LIKE '".$busquedaUsername."' AND id IN 
        (SELECT MAX(id) FROM users 
            WHERE name LIKE '".$busquedaUsername.
        "')";
        $query                           = DB::select( DB::raw($string));
        if($query != NULL)
        {
            foreach ($query as $key => $value) {
                $correlativo = (int)substr($value->expediente,1,3);
                if( $correlativo <= 9 ){
                    $user->name = $username."00".strval($correlativo+1)."-".$anio;
                }elseif ( $correlativo <= 99 ) {
                    $user->name = $username."0".strval($correlativo+1)."-".$anio;
                }else{
                    $user->name = $username.strval($correlativo+1)."-".$anio;
                }
            }
        }else{
            $user->name = $username."001-".$anio;
        }
        //FIN LOGICA PARA CREACION DE NOMBRE DE USUARIOS
        $user->email              = $request->email;
        $user->password           = bcrypt($password);
        $user->save();
        $rol                      = Role::where('slug',$request->role)->get();
        $user->roles()->sync($rol[0]['id']);
        $persona                     = new Persona();
        $persona->primer_nombre      = $request->primer_nombre;
        $persona->primer_apellido    = $request->primer_apellido;
        $persona->segundo_nombre     = $request->segundo_nombre;
        $persona->segundo_apellido   = $request->segundo_apellido;
        $persona->direccion          = $request->direccion;
        $persona->telefono           = $request->telefono;
        $persona->numero_junta       = $request->numero_junta;
        $persona->user_id            = $user->id;
        $persona->save();

        Mail::send('email.user',['user'=> $user,'password'=>$password], function($m) use($user){
            $m->to($user->email,$user->persona->primer_nombre." ".$user->persona->primer_apellido);
            $m->subject('Contraseña y nombre de usuario');
            $m->from('clinicayekixpaki@gmail.com','Sana Dental');
        });
        return redirect()->route('users.index')->with('success','El Usuario se ingresó correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user   =   User::find($id);
        $roles  =   Role::where('id','<>',1)->get();
        return view('usuarios.show_user',compact('roles','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user   =   User::find($id);
        $roles  =   Role::where('id','<>',1)->get();
        return view('usuarios.edit_user',compact('roles','user'));
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
        $request->validate([
            'primer_nombre' => 'required',
            'primer_apellido' => 'required',
            'direccion' => 'required',
            'telefono' => 'required|regex:/^\d{4}-\d{4}$/',
            'role' => 'required'
        ]);

        $user                     = User::find($id);
        //VALIDACION EMAIL REPETIDO
        if($user->email != $request->email){
            $validarEmail = User::where('email',$request->email)->get();
            if(sizeof($validarEmail) == 0){
                $user->email = $request->email;
                $user->save();
            }else{
                return back()->with('danger','Error, El campo email ya está en uso');
            }
        }
        $rol                      = Role::where('slug',$request->role)->get();
        $user->roles()->sync($rol[0]['id']);
        $persona = Persona::find($user->persona->id);
        $persona->primer_nombre      = $request->primer_nombre;
        $persona->primer_apellido    = $request->primer_apellido;
        $persona->segundo_nombre     = $request->segundo_nombre;
        $persona->segundo_apellido   = $request->segundo_apellido;
        $persona->direccion          = $request->direccion;
        $persona->telefono           = $request->telefono;
        if($rol[0]['slug'] != 'doctor'){
            $persona->numero_junta       = null;
        }else{
            $persona->numero_junta       = $request->numero_junta;
        }
        
        $persona->save();
        
        return redirect('users')->with('success','El Usuario se actualizó correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->id != 1){
            $rol = Role::where('slug','Suspendido')->get();
            $user->roles()->sync($rol[0]['id']);
            return redirect('users')->with('success','Usuario eliminado con exito');
        }else{
            return redirect()->back()->with('danger','El usuario seleccionado no se puede eliminar');
        }
        
    }
}
