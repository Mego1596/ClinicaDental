<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Calendar;
use App\Procedimiento;
use Datetime;
use App\Cita;
use Caffeinated\Shinobi\Models\Role;
use Auth;
use DB;
use Hash;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->hasRole('suspendido')){
            Auth::logout();
            return redirect()->route('login')->with('danger','Su cuenta ha sido suspendida');
        }
        $event_list                 =   [];
        $fecha_actual               =   new Datetime('now');
        $fecha_actual_completa      =   $fecha_actual->format('Y-m-d');
        $citas                      =   Cita::whereRaw("reprogramado = 0 AND fecha_hora_inicio >= '$fecha_actual_completa'")->get();
        $persona                    =   Auth::user()->persona;
        $es_paciente                =   Auth::user()->hasRole('paciente');
        $botones                    =   !$es_paciente?"prev,next today paciente_nuevo paciente_antiguo":"prev,next today";
        $listado_procedimientos     =   Procedimiento::all();
        foreach($citas as $cita){
            $array_procedimientos       =   [];
            $ruta_pago                  =   "";
            $ruta_receta                =   "";
            $ruta_expediente            =   "";
            $ruta_seguimiento           =   "";
            $procedimientos             = $cita->procedimientos()->where('cita_id',$cita->id)->get();

            foreach ($procedimientos as $key => $procedimiento_parcial) {
                $array_procedimientos[]                         =   $procedimiento_parcial;
                $stringSQL                                      =   "SELECT honorarios,numero_piezas FROM procedimiento_citas 
                                                                    WHERE cita_id=".$procedimiento_parcial->pivot->cita_id.
                                                                    " AND procedimiento_id =".$procedimiento_parcial->pivot->procedimiento_id;
                $resultado                                      =   DB::select(DB::raw($stringSQL));
                $array_procedimientos[$key]['numero_piezas']    =   $resultado[0]->numero_piezas;
                $array_procedimientos[$key]['honorarios']       =   $resultado[0]->honorarios;
            }
            $nombre_completo            = $cita->persona->primer_nombre." ".$cita->persona->segundo_nombre." "
                                          .$cita->persona->primer_apellido." ".$cita->persona->segundo_apellido;
            $descripcion                = $cita->descripcion;
            if($es_paciente){
                if($persona->id != $cita->persona->id){
                    $color              = '#414FEF';
                    $titulo             = "Ocupado";
                    $nombre_completo    = "Cupo Reservado";
                    $procedimiento      = "Oculto";
                    $descripcion        = "Sin descripción";
                }else{
                    $color  = '#000000';
                    $titulo = $cita->persona->expediente->numero_expediente." ".$cita->persona->primer_nombre." ".$cita->persona->primer_apellido;
                    $ruta_receta        =   route('citas.recetas.index',['cita' => $cita->id]);
                }
            }else{
                if(empty($cita->persona->expediente)){
                    $color              =   '#414FEF';
                    $titulo             =   $cita->persona->primer_nombre." ".$cita->persona->primer_apellido;
                    $ruta_expediente    =   route('expedientes.especial',['persona' => $cita->persona->id]);
                }else{
                    $color              =   '#000000';
                    $titulo             =   $cita->persona->expediente->numero_expediente." ".
                                            $cita->persona->primer_nombre." ".$cita->persona->primer_apellido;
                    $ruta_pago          =   route('citas.pagos.index',['cita' => $cita->id]);
                    $ruta_receta        =   route('citas.recetas.index',['cita' => $cita->id]);
                    $ruta_seguimiento   =   route('citas.seguimiento',['cita'=>$cita->id]);
                }
            }
            $event_list[] = Calendar::event(
                $titulo,
                false, //full day event?
                new DateTime($cita->fecha_hora_inicio),
                new DateTime($cita->fecha_hora_fin),
                $cita->id, //optional event ID
                [
                    'color'                     =>  $color,
                    'nombre_completo'           =>  $nombre_completo,
                    'descripcion'               =>  $descripcion,
                    'durationEditable'          =>  false,
                    'procedimiento'             =>  $array_procedimientos,
                    'pagos'                     =>  $ruta_pago,
                    'recetas'                   =>  $ruta_receta,
                    'expedientes'               =>  $ruta_expediente,
                    'listado'                   =>  $listado_procedimientos,
                    'edicion'                   =>  route('citas.update',['cita' => $cita->id] ),
                    'eliminar'                  =>  route('citas.destroy',['cita' => $cita->id]),
                    'reprogramar'               =>  route('citas.reprogramar',['cita' => $cita->id]),
                    'seguimiento'               =>  $ruta_seguimiento
                ]
            );            
            unset($array_procedimientos);
            unset($ruta_pago);
            unset($ruta_receta);
            unset($ruta_expediente);
            unset($ruta_seguimiento);
        }
        $calendar = Calendar::addEvents($event_list)->setOptions([
            'firstDay'      => 1,
            'editable'      => false,
            'themeSystem'   =>'bootstrap4',
            'locale'        => 'es',

            'customButtons' => [
                'paciente_nuevo' => [
                  'text' => 'Nuevo Paciente',
                ],
                'paciente_antiguo' => [
                  'text' => 'Antiguo Paciente',
                ],
            ],
            'buttonText'=> array(
                'today'     => 'Hoy',
                'month'     => 'Mes',
                'week'      => 'Semana',
                'day'       => 'Día'
            ),
            'defaultView'   => 'month',
            'header'        => array(
                'left'          => $botones, 
                'center'        => 'title', 
                'right'         => 'month,agendaWeek,agendaDay'
            )
            
            ])->setCallbacks([
                'eventClick' => 'function(calEvent,jsEvent,view){
                    $("#nombre_completo").val(calEvent.nombre_completo)
                    let fecha_inicio    =  new Date(calEvent.start)
                    
                    //texto para enviar al modal de eliminar cita
                    inicio_eliminar     =  fecha_inicio.getDate()+"/"+(fecha_inicio.getMonth()+1)+"/"+fecha_inicio.getFullYear()+" "
                    inicio_eliminar    +=  fecha_inicio.getHours() < 10? "0"+fecha_inicio.getHours()+":":fecha_inicio.getHours()+":"
                    inicio_eliminar    +=  fecha_inicio.getMinutes() < 10? "0"+fecha_inicio.getMinutes():fecha_inicio.getMinutes()

                    //texto para setear el campo datetime en los detalles de la cita
                    inicio_string       =  fecha_inicio.getFullYear()+"-"
                    inicio_string      +=  (fecha_inicio.getMonth()+1) < 10 ? "0"+(fecha_inicio.getMonth()+1):(fecha_inicio.getMonth()+1)
                    inicio_string      +=  "-"
                    inicio_string      +=  fecha_inicio.getDate() < 10 ? "0"+fecha_inicio.getDate():fecha_inicio.getDate()
                    inicio_string      +=  "T"
                    inicio_string      +=  fecha_inicio.getHours() < 10? "0"+fecha_inicio.getHours()+":":fecha_inicio.getHours()+":"
                    inicio_string      +=  fecha_inicio.getMinutes() < 10? "0"+fecha_inicio.getMinutes():fecha_inicio.getMinutes()

                    let fecha_fin       =  new Date(calEvent.end)
                    
                    //texto para enviar al modal de eliminar cita
                    fin_eliminar        =  fecha_fin.getDate()+"/"+(fecha_fin.getMonth()+1)+"/"+fecha_fin.getFullYear()+" "
                    fin_eliminar       +=  fecha_fin.getHours() < 10? "0"+fecha_fin.getHours()+":":fecha_fin.getHours()+":"
                    fin_eliminar       +=  fecha_fin.getMinutes() < 10? "0"+fecha_fin.getMinutes():fecha_fin.getMinutes()

                    //texto para setear el campo datetime en los detalles de la cita
                    fin_string          =  fecha_fin.getFullYear()+"-"
                    fin_string         +=  (fecha_fin.getMonth()+1) < 10 ? "0"+(fecha_fin.getMonth()+1):(fecha_fin.getMonth()+1)
                    fin_string         +=  "-"
                    fin_string         +=  fecha_fin.getDate() < 10 ? "0"+fecha_fin.getDate():fecha_fin.getDate()
                    fin_string         +=  "T"
                    fin_string         +=  fecha_fin.getHours() < 10? "0"+fecha_fin.getHours()+":":fecha_fin.getHours()+":"
                    fin_string         +=  fecha_fin.getMinutes() < 10? "0"+fecha_fin.getMinutes():fecha_fin.getMinutes()
                    $("#fecha_hora_inicio_3").val(inicio_string)
                    $("#fecha_hora_fin_3").val(fin_string)
                    $("#descripcion_3").val(calEvent.descripcion)
                    $("#edit_fecha_hora_inicio").val(inicio_string)
                    $("#edit_fecha_hora_fin").val(fin_string)
                    $("#edit_descripcion").val(calEvent.descripcion)
                    $("#label_paciente").text(calEvent.nombre_completo)
                    $("#label_hora_inicio").text(inicio_eliminar)
                    $("#label_hora_fin").text(fin_eliminar)
                    $("#div_procedimientos").empty()
                    let html_code       = ""
                    let numero_select   = [];
                    var count = Object.keys(calEvent.procedimiento).length
                    $("#form_editar #procedimientos_create").empty()
                    if(calEvent.procedimiento != ""){
                        $.each(calEvent.procedimiento, function(i,atributos){
                            html_code = html_code
                            +"<div class=\"form-group row\">"
                                +"<div class=\"col-sm-4\">"
                                    +"Procedimiento"
                                +"</div>"
                                +"<div class=\"col-sm-4\">"
                                    +"Numero de piezas"
                                +"</div>"
                                +"<div class=\"col-sm-4\">"
                                    +"Honorarios"
                                +"</div>"
                            +"</div>"
                            +"<div class=\"form-group row\">"
                                +"<div class=\"col-sm-4\">"
                                    +"<input id=\"procedimiento_"+(i+1)+"\" type=\"text\" class=\"form-control\" value=\""+atributos["nombre"]+"\" readonly disabled>"
                                +"</div>"
                                +"<div class=\"col-sm-4\">"
                                    +"<input id=\"numero_piezas_"+(i+1)+"\" type=\"text\" class=\"form-control\" value=\""+atributos["numero_piezas"]+"\" readonly disabled>"
                                +"</div>"
                                +"<div class=\"col-sm-4\">"
                                    +"<input id=\"honorarios_"+(i+1)+"\" type=\"text\" class=\"form-control\" value=\""+atributos["honorarios"]+"\" readonly disabled>"
                                +"</div>"
                            +"</div>"

                            let html_code2      = ""
                            html_code2 = html_code2
                                +"<div class=\"form-group row\" id=\"procedimiento_select_antiguo_"+(i+1)+"\">" 
                                    +"<div class=\"col-sm-3\">"
                            if(i == count - 1){
                                html_code2 = html_code2
                                +"<select class=\"form-control\" id=\"select_"+(i+1)+"\" name=\"procedimiento["+(i+1)+"][id]\" required>"
                                            +"<option value=\"\" selected disabled>Seleccione el procedimiento</option>"
                            }else{
                                html_code2 = html_code2
                                +"<select class=\"form-control\" id=\"select_"+(i+1)+"\" name=\"procedimiento["+(i+1)+"][id]\" readonly disabled required>"
                                            +"<option value=\"\" selected disabled>Seleccione el procedimiento</option>"
                            }
                                        
                            $.each(calEvent.listado, function(iteration,value){
                                if( i == 0 ){
                                    if(atributos["pivot"]["procedimiento_id"] == value["id"]){
                                        html_code2 = html_code2
                                            +"<option id=\"procedimiento_"+value["id"]+"\" value=\""+value["id"]+"\" selected>"+value["nombre"]+"</option>"
                                    }else{
                                        html_code2 = html_code2
                                            +"<option id=\"procedimiento_"+value["id"]+"\" value=\""+value["id"]+"\">"+value["nombre"]+"</option>"
                                    }
                                }else{
                                    if(!numero_select.includes(value["id"])){
                                        if(atributos["pivot"]["procedimiento_id"] == value["id"]){
                                            html_code2 = html_code2
                                            +"<option id=\"procedimiento_"+value["id"]+"\" value=\""+value["id"]+"\" selected>"+value["nombre"]+"</option>"
                                        }else{
                                            html_code2 = html_code2
                                            +"<option id=\"procedimiento_"+value["id"]+"\" value=\""+value["id"]+"\">"+value["nombre"]+"</option>"
                                        }
                                    }

                                }
                                
                            });
                            
                            numero_select.push(atributos["pivot"]["procedimiento_id"])
                            if( i == count-1){
                                html_code2 = html_code2
                                        +"</select>"
                                    +"</div>"
                                    +"<div class=\"col-sm-4\">"
                                        +"<input id=\"input_1_"+(i+1)+"\" type=\"number\" step=\"1\" min=\"1\" max=\"32\" name=\"procedimiento["+(i+1)+"][numero_piezas]\" class=\"form-control\" placeholder=\"Numero de piezas\" value="+atributos["numero_piezas"]+" required />"
                                    +"</div>"
                                    +"<div class=\"col-sm-4\">"
                                        +"<input id=\"input_2_"+(i+1)+"\" type=\"number\" step=\"0.01\" min=\"0.01\" name=\"procedimiento["+(i+1)+"][honorarios]\" class=\"form-control\" placeholder=\"Honorarios\" value="+atributos["honorarios"]+" required />"
                                    +"</div>"
                                    +"<div class=\"col-sm-1\" id=\"remove_div_"+(i+1)+"\">"
                                        +"<i class=\" btn far fa-times-circle\" style=\"color:red\" onclick=\"removeProcedimiento("+(i+1)+",2)\" id=\"remove_"+(i+1)+"\"></i>"
                                    +"</div>"
                                +"</div>"  
                            }else{
                                html_code2 = html_code2
                                        +"</select>"
                                    +"</div>"
                                    +"<div class=\"col-sm-4\">"
                                        +"<input id=\"input_1_"+(i+1)+"\" type=\"number\" step=1 min=1 max=32 name=\"procedimiento["+(i+1)+"][numero_piezas]\" class=\"form-control\" placeholder=\"Numero de piezas\" value="+atributos["numero_piezas"]+" required  readonly disabled/>"
                                    +"</div>"
                                    +"<div class=\"col-sm-4\">"
                                        +"<input id=\"input_2_"+(i+1)+"\" type=\"number\" step=0.01 min=0.01 name=\"procedimiento["+(i+1)+"][honorarios]\" class=\"form-control\" placeholder=\"Honorarios\" value="+atributos["honorarios"]+" required readonly disabled />"
                                    +"</div>"
                                    +"<div class=\"col-sm-1\" id=\"remove_div_"+(i+1)+"\"></div>"
                                +"</div>"
                            }
                            $("#form_editar #procedimientos_create").append(html_code2)
                        });
                        $("#div_procedimientos").html(html_code)
                    }
                    $("#form_editar").attr("action",calEvent.edicion)
                    $("#form_eliminar").attr("action",calEvent.eliminar)
                    $("#form_reprogramar").attr("action",calEvent.reprogramar)
                    $("#form_seguimiento").attr("action",calEvent.seguimiento)
                    $("#cita_padre").val(calEvent.id)
                    $("#btn_expediente").empty()
                    $("#btn_pago").empty()
                    $("#btn_receta").empty()
                    $("#btn_seguimiento").empty()
                    if(calEvent.title != "Ocupado"){
                        if(calEvent.expedientes != ""){
                            $("#btn_expediente").html(
                                "<a id=\"1\" class=\"btn btn-outline-primary\"><i class=\"fas fa-address-card\"></i> Crear Expediente</a>"
                            )
                            $("#1").attr("href",calEvent.expedientes).css("margin","6px").css("border-radius","5px")
                        }else{
                            $("#btn_pago").html(
                                "<a id=\"1\" class=\"btn btn-outline-primary\"><i class=\"fas fa-money-check-alt\"></i> Gestionar Pago</a>"
                                
                            );
                            $("#btn_receta").html(
                                "<a id=\"2\" class=\"btn btn-outline-primary\"><i class=\"fas fa-notes-medical\"></i> Gestionar Receta</a>"
                            );
                            $("#1").attr("href",calEvent.pagos).css("margin","6px").css("border-radius","5px")
                            $("#2").attr("href",calEvent.recetas).css("margin","6px").css("border-radius","5px")
                            if(calEvent.expedientes == ""){
                                $("#btn_seguimiento").html(
                                    "<a id=\"3\" class=\"btn btn-outline-info\" onclick=\"$(\'#proximaCita\').modal(\'show\').on(\'shown.bs.modal\',function(e){});$(\'#fecha_hora_inicio_4\').attr(\'value\',\'\');$(\'#fecha_hora_fin_4\').attr(\'value\',\'\'); \"><i class=\"fas fa-notes-medical\"></i> Proxima Cita</a>"
                                    
                                )
                                $("#3").attr("href","#").css("margin","6px").css("border-radius","5px")
                            }
                        }
                    }
                    $("#showCita").modal()
                }',
            ]);
        return view('home',compact('calendar','listado_procedimientos'));
    }

    public function perfil(){
        return view('perfil');
    }

    public function changePassword(Request $request){
        $this->validate($request,[
            'old_password'  => 'required|string',
            'password'      => 'required_with:password-confirm|same:password_confirmation|string|min:6',
        ]);

        if(!Hash::check($request->old_password, Auth::user()->password, [])){
            return redirect()->back()->with('danger','La contraseña actual es incorrecta');
        }else{
            $user               =   User::find(Auth::user()->id);
            $user->password     =   bcrypt($request->password);
            $user->save();
            return redirect()->back()->with('success','La contraseña se actualizo con exito');
        }
    }
}



