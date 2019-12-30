<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Pago extends Model
{
    public function cita()
    {
        return $this->belongsTo('App\Cita','cita_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public static function total_plan(Cita $cita,$verificador = 1):float{
        $total          = 0.0;
        $total_padre    = 0.0;
        $total_hijos    = 0.0;
        $total_abonos   = 0.0;
        if(isset($cita->cita_id)){
            $cita_padre  = Cita::where('reprogramado',0)->whereNull('cita_id')->where('id',$cita->cita_id)->get();
            $citas_hijas = Cita::where('reprogramado',0)->where('cita_id', $cita->cita_id)->get();
            if(isset($cita_padre[0]->procedimientos)){
                $total_padre        = self::honorarios($cita_padre[0]);
            }
            if(isset($cita_padre[0]->pago)){
                    $total_abonos  +=   $cita_padre[0]->pago->abono;
            }
            foreach ($citas_hijas as $cita_actual) {
                if(isset($cita_actual->procedimientos)){
                    $total_hijos   += self::honorarios($cita_actual);
                }
                if(isset($cita_actual->pago)){
                    $total_abonos  +=   $cita_actual->pago->abono;
                }
            }
        }else{
            $citas_hijas = Cita::where('reprogramado',0)->where('cita_id', $cita->id)->get();
            if(isset($cita->procedimientos)){
                $total_padre     = self::honorarios($cita);
                if(isset($cita->pago)){
                    $total_abonos  +=   $cita->pago->abono;
                }
            }
            foreach ($citas_hijas as $cita_actual) {
                if(isset($cita_actual->procedimientos)){
                    $total_hijos   += self::honorarios($cita_actual);
                }
                if(isset($cita_actual->pago)){
                    $total_abonos  +=   $cita_actual->pago->abono;
                }
            }
        }

        if($verificador == 1){
            $total = ($total_padre + $total_hijos) - $total_abonos;
        }else{
            $total = $total_padre + $total_hijos;
        }
        return $total;
    }

    public static function honorarios(Cita $cita):float{
        $total = 0.0;
        foreach ($cita->procedimientos as $procedimiento_actual) {
            $stringSQL                                      =   "SELECT honorarios,numero_piezas FROM procedimiento_citas 
                                                            WHERE cita_id=".$procedimiento_actual->pivot->cita_id.
                                                            " AND procedimiento_id =".$procedimiento_actual->pivot->procedimiento_id;
            $resultado                                      =   DB::select(DB::raw($stringSQL));
            $total                                         +=   $resultado[0]->honorarios;
        }
        return $total;
    }
}
