<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Calendar;
use App\Procedimiento;
use Datetime;
use App\Cita;
use Auth;
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
        $event_list                 =   [];
        $fecha_actual               =   new Datetime('now');
        $fecha_actual               =   $fecha_actual->format('Y-m-d');
        $citas                      =   Cita::where('reprogramado',false)->whereRaw("fecha_hora_inicio >= '$fecha_actual'")->get();
        $persona                    =   Auth::user()->persona;
        $es_paciente                =   Auth::user()->hasRole('paciente');
        $ruta_pago                  =   "";
        $ruta_receta                =   "";
        $ruta_expediente            =   "";
        $botones                    =   !$es_paciente?"prev,next today paciente_nuevo paciente_antiguo":"prev,next today";
        $array_procedimientos       =   [];
        $listado_procedimientos     =   Procedimiento::all();
        foreach($citas as $cita){
            $procedimientos             = $cita->procedimientos()->where('cita_id',$cita->id)->get();
            foreach ($procedimientos as $key => $procedimiento_parcial) {
                $array_procedimientos[] = $procedimiento_parcial;
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
                }
            }else{
                if(is_null($cita->persona->expediente)){
                    $color              =   '#414FEF';
                    $titulo             =   $cita->persona->primer_nombre." ".$cita->persona->primer_apellido;
                    $ruta_expediente    =   route('expedientes.especial',['persona' => $cita->persona->id]);
                }else{
                    $color          =   '#000000';
                    $titulo         =   $cita->persona->expediente->numero_expediente." ".
                                        $cita->persona->primer_nombre." ".$cita->persona->primer_apellido;
                    $ruta_pago      =   route('citas.pagos.index',['cita' => $cita->id]);
                    $ruta_receta    =   route('citas.recetas.index',['cita' => $cita->id]);
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
                ]
            );            
            unset($array_procedimientos);
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
                    inicio_string       =  fecha_inicio.getFullYear()+"-"+(fecha_inicio.getMonth()+1)+"-"+fecha_inicio.getDate()+"T"
                    inicio_string      +=  fecha_inicio.getHours() < 10? "0"+fecha_inicio.getHours()+":":fecha_inicio.getHours()+":"
                    inicio_string      +=  fecha_inicio.getMinutes() < 10? "0"+fecha_inicio.getMinutes():fecha_inicio.getMinutes()
                    let fecha_fin       =  new Date(calEvent.end)
                    fin_string          =  fecha_fin.getFullYear()+"-"+(fecha_fin.getMonth()+1)+"-"+fecha_fin.getDate()+"T"
                    fin_string         +=  fecha_fin.getHours() < 10? "0"+fecha_fin.getHours()+":":fecha_fin.getHours()+":"
                    fin_string         +=  fecha_fin.getMinutes() < 10? "0"+fecha_fin.getMinutes():fecha_fin.getMinutes()
                    $("#fecha_hora_inicio_3").val(inicio_string)
                    $("#fecha_hora_fin_3").val(fin_string)
                    $("#descripcion_3").val(calEvent.descripcion)
                    $("#edit_fecha_hora_inicio").val(inicio_string)
                    $("#edit_fecha_hora_fin").val(fin_string)
                    $("#edit_descripcion").val(calEvent.descripcion)
                    $("#div_procedimientos").empty()
                    let html_code       = ""
                    let numero_select   = [];
                    var count = Object.keys(calEvent.procedimiento).length
                    $("#form_editar #procedimientos_create").empty()
                    $("#showCita form#procedimientos_create").empty()
                    if(calEvent.procedimiento != ""){
                        $.each(calEvent.procedimiento, function(i,atributos){
                            html_code = html_code
                            +"<div class=\"form-group row\">"
                                +"<label for=\"procedimiento_"+(i+1)+"\" class=\"col-sm-6 col-form-label\">Procedimiento:</label>"
                                +"<div class=\"col-sm-6\">"
                                    +"<input id=\"procedimiento_"+(i+1)+"\" type=\"text\" class=\"form-control\" value=\""+atributos["nombre"]+"\" readonly disabled>"
                                +"</div>"
                            +"</div>"

                            let html_code2      = ""
                            html_code2 = html_code2
                                +"<div class=\"form-group row\" id=\"procedimiento_select_antiguo_"+(i+1)+"\">"
                                    +"<label for=\"procedimiento_select_antiguo_"+(i+1)+"\" class=\"col-sm-6 col-form-label\">Procedimiento:</label>" 
                                    +"<div class=\"col-sm-5\">"
                            if(i == count - 1){
                                html_code2 = html_code2
                                +"<select class=\"form-control\" id=\"select_"+(i+1)+"\" name=\"procedimiento[]\" >"
                                            +"<option value=\"\" selected disabled>Seleccione</option>"
                            }else{
                                html_code2 = html_code2
                                +"<select class=\"form-control\" id=\"select_"+(i+1)+"\" name=\"procedimiento[]\" readonly disabled>"
                                            +"<option value=\"\" selected disabled>Seleccione</option>"
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
                                    +"<div class=\"col-sm-1\" id=\"remove_div_"+(i+1)+"\">"
                                        +"<i class=\" btn far fa-times-circle\" style=\"color:red\" onclick=\"removeProcedimiento("+(i+1)+",2)\" id=\"remove_"+(i+1)+"\"></i>"
                                    +"</div>"
                                +"</div>"  
                            }else{
                                html_code2 = html_code2
                                        +"</select>"
                                    +"</div>"
                                    +"<div class=\"col-sm-1\" id=\"remove_div_"+(i+1)+"\"></div>"
                                +"</div>"
                            }
                            $("#form_editar #procedimientos_create").append(html_code2)
                        })
                        $("#form_editar").attr("action",calEvent.edicion)
                        $("#div_procedimientos").html(html_code)
                    }
                    
                    $("#botones").empty()                        
                    if(calEvent.expedientes != ""){
                        $("#botones").html(
                            "<a id=1 class=\"btn btn-outline-primary\">Crear Expediente</a>"+
                            "<a id=2 class=\"btn btn-outline-info\">Reprogramar Cita</a>"
                        )
                        $("#1").attr("href",calEvent.expedientes).css("margin","6px").css("border-radius","5px")
                        $("#2").attr("href",calEvent.recetas).css("margin","6px").css("border-radius","5px")
                    }else{
                        $("#botones").html(
                            "<a id=1 class=\"btn btn-outline-primary\">Gestionar Pago</a>"+
                            "<a id=2 class=\"btn btn-outline-primary\">Gestionar Receta</a>"+
                            "<a id=3 class=\"btn btn-outline-info\">Reprogramar Cita</a>"
                        );
                        $("#1").attr("href",calEvent.pagos).css("margin","6px").css("border-radius","5px")
                        $("#2").attr("href",calEvent.recetas).css("margin","6px").css("border-radius","5px")
                        $("#3").attr("href",calEvent.recetas).css("margin","6px").css("border-radius","5px")
                    }
                    $("#showCita").modal()
                }',
            ]);
        $procedimientos = Procedimiento::all();
        return view('home',compact('calendar','procedimientos'));
    }
}
