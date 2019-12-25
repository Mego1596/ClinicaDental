<?php

namespace App;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    public function pago()
    {
        return $this->hasOne('App\Pago');
    }

    public static function esValida (Cita $cita){
        $mensaje = "La cita ha presentado los siguientes problemas: \n";


        $inicio = new DateTime($cita->fecha_hora_inicio);
        $fin = new DateTime($cita->fecha_hora_fin);

        $actual = new DateTime($inicio->format('Y-m-d'));
        $hora_entrada = new DateTime($actual->format('Y-m-d 08:00:00'));
        $inicio_almuerzo = new DateTime($actual->format('Y-m-d 12:00:00'));
        
        /**Reglas de negocio para validación de citas */
        if(date('l',strtotime($actual->format('Y-m-d')))=='Saturday'){
            $fin_almuerzo = new DateTime($actual->format('Y-m-d 13:00:00'));
            $hora_salida = new DateTime($actual->format('Y-m-d 15:00:00'));

        }else{
            $fin_almuerzo = new DateTime($actual->format('Y-m-d 14:00:00'));
            $hora_salida = new DateTime($actual->format('Y-m-d 18:00:00'));
        }
        
        //validacion duracion minima: 30 minutos
        $d = $inicio->diff($fin);
        $duracion_minima = $d->y==0 && $d->m==0 && $d->d==0 && $d->h==0 && $d->i<=29;
        //validacion inicio y fin debe ser en la misma fecha, el resultado se invertirá más adelante
        $mismo_dia = $inicio->format('Y-m-d') == $fin->format('Y-m-d');
        //validacion inicio y fin fuera de trabajo
        $horario_fuera = $inicio > $hora_salida || $fin > $hora_salida || $inicio < $hora_entrada;
        //validacion inicio o fin traslapa con hora de almuerzo
        $traslapa_almuerzo = ($inicio >= $inicio_almuerzo && $inicio < $fin_almuerzo) || ($fin > $inicio_almuerzo && $fin <= $fin_almuerzo);
        //validacion cita contiene la hora de almuerzo
        $contiene_almuerzo = $inicio <= $inicio_almuerzo && $fin >= $fin_almuerzo;
        
       //concatenación de mensajes
        $mensaje = $duracion_minima ? $mensaje."<li>La cita dura menos de 30 minutos.</li>" : $mensaje;

        $mensaje = $horario_fuera ? $mensaje."<li>La cita no está en horario laboral.</li>" : $mensaje;

        $mensaje = $contiene_almuerzo ? $mensaje."<li>La cita pasa sobre la hora de almuerzo.</li>" : $mensaje;

        $mensaje = $traslapa_almuerzo ? $mensaje."<li>La cita comienza o termina durante la hora de almuerzo.</li>" : $mensaje;

        $mensaje = !$mismo_dia ? $mensaje."<li>fecha de inicio y fin de cita debe ser el mismo dia.</li>" : $mensaje;

        if( $duracion_minima || $horario_fuera || $traslapa_almuerzo || $contiene_almuerzo || !$mismo_dia){
             return $mensaje;
        }
    
        //validacion cita no choca con otras que ya están registradas
       $revision = Cita::whereRaw("(fecha_hora_inicio > '$cita->fecha_hora_inicio' AND fecha_hora_inicio < '$cita->fecha_hora_fin')")
       ->orWhereRaw("(fecha_hora_fin > '$cita->fecha_hora_inicio' AND fecha_hora_fin < '$cita->fecha_hora_fin')")
       ->orWhereRaw("(fecha_hora_inicio <= '$cita->fecha_hora_inicio'  AND fecha_hora_fin >= '$cita->fecha_hora_fin')")->first();
       
       if(isset($revision)){
           return $mensaje."<li>La cita choca con otras que ya se registraron previamente</li>";
       }else{
           return null;
       }
    }
}
