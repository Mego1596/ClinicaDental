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
        $event_list = [];
        $fecha_actual = new Datetime('now');
        $fecha_actual=$fecha_actual->format('Y-m-d');

        $citas = Cita::where('reprogramado',false)->whereRaw("fecha_hora_inicio >= '$fecha_actual'")->get();
        

        $persona = Auth::user()->persona;
        $es_paciente = Auth::user()->hasRole('paciente');


        foreach($citas as $cita){

            $nombre_completo    = $cita->persona->primer_nombre." ".$cita->persona->segundo_nombre." ".$cita->persona->primer_apellido." ".$cita->persona->segundo_apellido;
            $procedimiento      = $cita->procedimiento->nombre;
            $descripcion        = $cita->descripcion;
            $persona_id         = 0;
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
                    $color              = '#414FEF';
                    $titulo             = $cita->persona->primer_nombre." ".$cita->persona->primer_apellido;
                    $persona_id         = $cita->persona->id;

                }else{
                    $color  = '#000000';
                    $titulo = $cita->persona->expediente->numero_expediente." ".$cita->persona->primer_nombre." ".$cita->persona->primer_apellido;
                }

            }

            $event_list[] = Calendar::event(
                $titulo,
                false, //full day event?
                new DateTime($cita->fecha_hora_inicio),
                new DateTime($cita->fecha_hora_fin),
                $cita->id, //optional event ID
                [
                    'color'             =>  $color,
                    'nombre_completo'   =>  $nombre_completo,
                    'descripcion'       =>  $descripcion,
                    'durationEditable'  =>  false,
                    'procedimiento'     =>  $procedimiento,
                    'persona_id'  =>  $persona_id,
                ]
            );            
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
                'today'=> 'Hoy',
                'month'=> 'Mes',
                'week' => 'Semana',
                'day' => 'Día'
            ),
            'defaultView' => 'month',
            'header' => array(
                'left' => 'prev,next today paciente_nuevo paciente_antiguo', 
                'center' => 'title', 
                'right' => 'month,agendaWeek,agendaDay'
                )
            ])->setCallbacks([
                'eventClick' => 'function(calEvent,jsEvent,view){
                    $("#nombre_completo").val(calEvent.nombre_completo)
                    let fecha_inicio =  new Date(calEvent.start)
                    inicio_string    =  fecha_inicio.getFullYear()+"-"+(fecha_inicio.getMonth()+1)+"-"+fecha_inicio.getDate()+"T"
                    inicio_string   +=  fecha_inicio.getHours() < 10? "0"+fecha_inicio.getHours()+":":fecha_inicio.getHours()+":"
                    inicio_string   +=  fecha_inicio.getMinutes() < 10? "0"+fecha_inicio.getMinutes():fecha_inicio.getMinutes()
                    let fecha_fin =  new Date(calEvent.end)
                    fin_string    =  fecha_fin.getFullYear()+"-"+(fecha_fin.getMonth()+1)+"-"+fecha_fin.getDate()+"T"
                    fin_string   +=  fecha_fin.getHours() < 10? "0"+fecha_fin.getHours()+":":fecha_fin.getHours()+":"
                    fin_string   +=  fecha_fin.getMinutes() < 10? "0"+fecha_fin.getMinutes():fecha_fin.getMinutes()
                    $("#fecha_hora_inicio_3").val(inicio_string)
                    $("#fecha_hora_fin_3").val(fin_string)
                    $("#procedimiento").val(calEvent.procedimiento)
                    $("#descripcion_3").val(calEvent.descripcion)
                    $("#botones").empty()
                    if(calEvent.persona_id != 0){
                        $("#botones").html(
                             "<a id=1 class=\"btn btn-primary\">Crear Expediente</a>"
                        );
                        $("#1").attr("href","expediente_create_especial/"+calEvent.persona_id).css("border-radius","5px")
                    }else{
                        $("#botones").html(
                             "<a id=1 class=\"btn btn-primary\">Gestionar Pago</a>"+
                             "<a id=2 class=\"btn btn-primary\">Gestionar Receta</a>"
                        );
                        $("#1").attr("href","pagos/"+calEvent.id).css("margin","2px").css("border-radius","5px")
                        $("#2").attr("href","pagos/"+calEvent.id).css("margin","2px").css("border-radius","5px")
                    }
                    $("#showCita").modal()
                }',
            ]);
        $procedimientos = Procedimiento::all();
        return view('home',compact('calendar','procedimientos'));
    }
}
