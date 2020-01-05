<!DOCTYPE html>
<html>
<head>
    <title>Plan Tratamiento</title>
    <style type="text/css">
        .titulo{
            text-align: center;
            padding-bottom: -1rem;
            font-family: Arial, Helvetica, sans-serif;
            font-weight:bolder;
            font-size: 17px;
        }

        .titulo2{
            text-align: center;
            padding-bottom: -1rem;
            padding-top: -1rem;
        }

        .titulo3{
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            font-weight:bolder;
            font-size: 15px;
            padding-bottom: -5rem;
            padding-top: .5rem;
        }

        .tabla-tra{
            margin-left: 19rem;
        }
        .separador{
            text-align: center;
        }

        .td-proc{

            border: 1px solid black;
            padding: 0em;
        }
        .alig{
            text-align: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-weight: bold;
            font-size: 15px;
        }
        .fuente{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size:14px;
        }

        .bordesB{
            border-left: 1px solid black;
            border-bottom: 1px solid black;
            border-top: 1px solid black;
        }
        .bordesA{
            border-right: 1px solid black;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        table{
            border-spacing: none;
        }
        .alineado{
            text-align: center;
        }
        .firmas{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: 13px;
        }
        .pac{
            padding-left: 5rem;
        }
        div.page_break{
        page-break-before: always;
        }
    </style>
    <style type="text/css">
        .tg2  {
            border-collapse:collapse;border-spacing:0;
        }
        .tg2 td{
            font-family:Arial, sans-serif;
            font-size:14px;
            padding:1px 5px;
            border-style:solid;
            border-width:1px;
            overflow:hidden;
            word-break:normal;
            border-color:black;
        }
        .tg2 th{
            font-family:Arial, sans-serif;
            font-size:14px;
            font-weight:normal;
            padding:1px 5px;
            border-style:solid;
            border-width:1px;
            overflow:hidden;
            word-break:normal;
            border-color:black;
        }
        .tg2 .tg-y9452{
            font-size:20px;
            font-family:"Arial Black", Gadget, sans-serif !important;
            border-color:#ffffff;
            text-align:center;
        }
        .tg2 .tg-dfg12{
            font-size:10px;
            border-color:#ffffff;
            text-align:center;
            vertical-align:top
        }
        .tg2 .tg-401l2{
            font-size:11px;
            border-color:#ffffff;
            text-align:center;
        }
        .tg2 .tg-ior22{
            font-size:11px;
            border-color:#ffffff;
            text-align:center;
            vertical-align:top
        }
    </style>
    <style type="text/css">
        .tg  {
            border-collapse:collapse;
            border-spacing:0;
            padding-left: .5rem;
        }
        .tg td{
            font-family:Arial, sans-serif;
            font-size:11px;
            padding:3px 5px;
            border-style:solid;
            border-width:1px;
            overflow:hidden;
            word-break:normal;
            border-color:black; 
            width: 400px;
        }
        .tg th{
            font-family:Arial, sans-serif;
            font-size:11px;
            font-weight:normal;
            padding:3px 5px;
            border-style:solid;
            border-width:1px;
            overflow:hidden;
            word-break:normal;
            border-color:black;
        }
        .tg .tg-s268{
            text-align:left
        }
        .tg .tg-0lax{
            text-align:left;
            vertical-align:top
        }
        .tg .bordes1{
            border-right: 1px solid white;
            border-left: 1px solid white;
            border-top: 1px solid white;
        }
        .tg .der{
            border-right: 1px solid white;
        }
    </style>
</head>
<body>
    <div>   
        <table class="tg2">
            <tr>
                <th class="tg-401l2" rowspan="2"><img src="img/titulo-yekixpaki.png" width="365" height="95"></th>
                <th class="tg-y9452"><span style="font-weight:bold">FICHA ODONTOLÓGICA</span></th>
            </tr>
            <tr>
                <td class="tg-401l2">Coronas, placas, puentes, rellenos, endodoncias, ortodoncias,<br>todo lo relacionado con Odontologia general, estetica e infantil.</td>
            </tr>
            <tr>
                <td class="tg-ior22" rowspan="2"><br>Col. Libertad, Av. Washington #414, San Salvador.<br>Telefono: 2102 - 2198</td>
                <td class="tg-ior22">De Lunes a miercoles, viernes y sabado de 2:00 pm a 6:00 pm</td>
            </tr>
            <tr>
                <td class="tg-dfg12"><span style="font-weight:bold">Telefono: (503) 6420-8735</span> - Domingos por cita</td>
            </tr>
        </table>
        <p class="titulo2">--------------------------------------------------------------------------------------------------------------------------------</p>
        <p class="titulo " style="font-weight:bold">DATOS DEL PACIENTE</p>
        
        <table class="tg" style="undefined;table-layout: fixed; width: 685px">
            <colgroup>
                <col style="width: 337px">
                <col style="width: 239px">
            </colgroup>
            <tr>
                <th class="tg-s268 bordes1">Fecha: {{$formato_fecha}}  </th>
                <th class="tg-0lax bordes1">Ficha#: {{$cita->id}} </th>
            </tr>
            <tr>
                @if(isset($cita->persona->user->email))
                    <td class="tg-0lax">E-mail: {{$cita->persona->user->email}}</td>
                @else
                    <td class="tg-0lax">E-mail: </td>
                @endif
                <td class="tg-0lax">FC: {{$cita->persona->expediente->numero_expediente}}</td>
            </tr>
            <tr>
                <td class="tg-0lax">Nombre: {{$cita->persona->primer_nombre." ".$cita->persona->segundo_nombre." ".$cita->persona->primer_apellido." ".$cita->persona->segundo_apellido}} </td>
                <td class="tg-0lax">Edad: {{$edad}} años</td>
            </tr>
            <tr>
                <td class="tg-0lax">Ocupacion: {{$cita->persona->expediente->ocupacion}}</td>
                <td class="tg-0lax">Responsable: {{$cita->persona->expediente->responsable}}</td>
            </tr>
            <tr>
                <td class="tg-0lax" colspan="2">Domicilio: {{$cita->persona->direccion}}</td>
            </tr>
            <tr>
                <td class="tg-0lax der"></td>
                <td class="tg-0lax">Telefono: {{$cita->persona->telefono}}</td>
            </tr>
            <tr>
                <td class="tg-0lax" colspan="2">Recomendado Por: {{$cita->persona->expediente->recomendado}}</td>
            </tr>
            <tr>
                <td class="tg-0lax" colspan="2">Historia Odontologica Anterior:</td>
            </tr>
            <tr>
                @if(!is_null($cita->persona->expediente->historia_odontologica))
                    <td class="tg-0lax" colspan="2">{{$cita->persona->expediente->historia_odontologica}}</td>
                @else
                    <td class="tg-0lax" colspan="2">
                        <br />
                    </td>
                @endif
            </tr>
            <tr>
                <td class="tg-0lax" colspan="2">Historia Medica Anterior:</td>
            </tr>
            <tr>
                @if(!is_null($cita->persona->expediente->historia_medica))
                    <td class="tg-0lax" colspan="2">{{$cita->persona->expediente->historia_medica}}</td>
                @else
                    <td class="tg-0lax" colspan="2">
                        <br />
                    </td>
                @endif
            </tr>
        </table>
        <div align="center">
            @if(sizeof($ultimo_odontograma) == 1)
                <div><h3>Inicial</h3></div>
                <div><img src="{{public_path('img/odontograma.png')}}" width="700px" height="235px"></div>
                <div><h3>Actual</h3></div>
                <div><img src="{{$ultimo_odontograma[0]->odontograma}}"width="700px" height="235px"></div>
            @else
                @if(sizeof($ultimo_odontograma) == 2)
                    <div><h3>Inicial</h3></div>
                    <div><img src="{{$ultimo_odontograma[1]->odontograma}}"width="700px" height="235px"></div>
                    <div><h3>Actual</h3></div>
                    <div><img src="{{$ultimo_odontograma[0]->odontograma}}"width="700px" height="235px"></div>
                @else
                    <div><h3>Inicial</h3></div>
                    <div><img src="{{public_path('img/odontograma.png')}}" width="700px" height="235px"></div>
                @endif
            @endif
        </div>
    </div>
    <div class="page_break">
        <p class="titulo" style="font-weight:bold">PLANES DE TRATAMIENTO</p>
        <table border="solid" class="tabla-tra">
            <tr>
                <th width="350px" class="td-proc alig">Clase de Tratamiento</th>
                <th width="160px" class="td-proc alig">No. de Piezas</th>
                <th width="100px" class="td-proc alig">Honorarios</th>
            </tr>
            <tbody>
                @foreach($bd_procedimientos as $key => $procedimiento)
                    @if(sizeof($procedimientos) != 0)
                        @foreach($procedimientos as $key => $procedimiento_plan)
                            @if($procedimiento_plan->id == $procedimiento->id)
                                <tr>
                                    <td class="td-proc fuente">{{$procedimiento_plan->nombre}}</td>
                                    @if($procedimiento_plan->numero_piezas !=0 && $procedimiento_plan->honorarios !=0 )
                                        <td class="td-proc fuente" align="center">{{$procedimiento_plan->numero_piezas}}</td>
                                        <td class="td-proc fuente" align="center">${{number_format($procedimiento_plan->honorarios, 2)}}</td>
                                    @else
                                        <td class="td-proc fuente"></td>
                                        <td class="td-proc fuente"></td>
                                    @endif
                                    
                                </tr>
                                @break
                            @else
                                @if($loop->last)
                                    <tr>
                                        <td class="td-proc fuente">{{$procedimiento->nombre}}</td>
                                        <td class="td-proc fuente"></td>
                                        <td class="td-proc fuente"></td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td class="td-proc fuente">{{$procedimiento->nombre}}</td>
                            <td class="td-proc fuente"></td>
                            <td class="td-proc fuente"></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tr>
                <td class="bordesB fuente" style="font-weight:bold">Costo total del presupuesto ($):</td>
                <td class="bordesA"></td>
                <td class="separador td-proc fuente">
                    $ {{$total}}
                </td>
            </tr>
        </table>
        <p></p>
        <p></p>
        <p></p>
        <table class="tabla-tra">
            <tr>
                <td width="325px" class="firmas">F: ____________________________</td>
                <td class="firmas">F: ____________________________</td>
            </tr>
            <tr>
                <td width="325px" class="firmas pac">Paciente</td>
                <td class="firmas" style="text-align:center">Medico</td>
            </tr>              
        </table>
    </div>
    <div class="page_break">
        <table border="solid">
            <tr align="center">
                <th width="120px" class="td-proc alig">Fecha</th>
                <th width="200px" class="td-proc alig">Tratamiento Realizado</th>
                <th width="150px" class="td-proc alig">Realizo el Tto.</th>
                <th width="60px" class="td-proc alig">Abono</th>
                <th width="60px" class="td-proc alig">Saldo</th>
                <th width="120px" class="td-proc alig">Proxima Cita</th>
            </tr>
            <tbody>

                <tr>
                    @if(isset($cita->pago))
                        @php
                            $total -= $cita->pago->abono
                        @endphp
                        <td class="td-proc fuente" align="center">
                            @php
                                $date           = date_create($cita->pago->fecha_hora_inicio);
                                $formato_fecha  = date_format($date,"d-m-Y");
                            @endphp
                            {{$formato_fecha}}
                        </td>
                        <td class="td-proc fuente" align="center">
                            @if($total == 0)
                                <strong>Solvente</strong>
                            @endif
                            @foreach($cita->procedimientos as $procedimientos)
                                {{$procedimientos->nombre}}
                            @endforeach
                            <br/>
                            {{$cita->descripcion}}
                        </td>
                        <td class="td-proc fuente" align="center">
                            Dr. {{$cita->pago->user->persona->primer_nombre." ".$cita->pago->user->persona->segundo_nombre." ".$cita->pago->user->persona->primer_apellido." ".$cita->pago->user->persona->segundo_apellido}}
                        </td>
                        <td class="td-proc fuente" align="center">
                            $ {{$cita->pago->abono}}
                        </td>
                        <td class="td-proc fuente" align="center">
                            $ {{number_format($total, 2)}}
                        </td>
                        <td class="td-proc fuente" align="center">
                            @php
                                $date           = date_create($citas_hijas[0]->fecha_hora_inicio);
                                $formato_fecha  = date_format($date,"d-m-Y");
                            @endphp
                            {{$formato_fecha}}
                        </td>
                    @endif
                </tr>
                @if(sizeof($citas_hijas) != 0)
                    @foreach($citas_hijas as $key => $cita)
                        @if(isset($cita->pago))
                            @php
                                $total -= $cita->pago->abono
                            @endphp
                            <tr>
                                <td class="td-proc fuente" align="center">
                                    @php
                                        $date           = date_create($cita->fecha_hora_inicio);
                                        $formato_fecha  = date_format($date,"d-m-Y");
                                    @endphp
                                    {{$formato_fecha}}
                                </td>
                                <td class="td-proc fuente" align="center">
                                    @if($total == 0)
                                        <strong>Solvente</strong>
                                    @endif
                                    @foreach($cita->procedimientos as $procedimientos)
                                        {{$procedimientos->nombre}}
                                    @endforeach
                                    <br/>
                                    {{$cita->descripcion}}
                                </td>
                                <td class="td-proc fuente" align="center">
                                    Dr. {{$cita->pago->user->persona->primer_nombre." ".$cita->pago->user->persona->segundo_nombre." ".$cita->pago->user->persona->primer_apellido." ".$cita->pago->user->persona->segundo_apellido}}
                                </td>
                                <td class="td-proc fuente" align="center">
                                    
                                    $ {{$cita->pago->abono}}
                                </td>
                                <td class="td-proc fuente" align="center">
                                    $ {{number_format($total, 2)}}
                                </td>
                                <td class="td-proc fuente" align="center">
                                    @if(!$loop->last)
                                        @php
                                            $date           = date_create($citas_hijas[$key+1]->fecha_hora_inicio);
                                            $formato_fecha  = date_format($date,"d-m-Y");
                                        @endphp
                                        {{$formato_fecha}}
                                    @endif
                                </td>
                           </tr>
                        @else
                            @if($cita->reprogramado == true)
                                <tr>
                                    <td class="td-proc fuente" align="center">
                                        @php
                                            $date           = date_create($cita->fecha_hora_inicio);
                                            $formato_fecha  = date_format($date,"d-m-Y");
                                        @endphp
                                        {{$formato_fecha}}
                                    </td>
                                    <td class="td-proc fuente" align="center">
                                        @if($total == 0)
                                            <strong>Solvente</strong>
                                        @endif
                                        <br/>
                                        <strong>Cita Reprogramada</strong><br/>
                                        @foreach($cita->procedimientos as $procedimientos)
                                            {{$procedimientos->nombre}}
                                        @endforeach
                                        <br/>
                                        {{$cita->descripcion}}
                                    </td>
                                    <td class="td-proc fuente" align="center">
                                        Cita Reprogramada
                                    </td>
                                    <td class="td-proc fuente" align="center">
                                        $ 0.00
                                    </td>
                                    <td class="td-proc fuente" align="center">
                                        $ {{number_format($total, 2)}}
                                    </td>
                                    <td class="td-proc fuente" align="center">
                                        @if(!$loop->last)
                                            @php
                                                $date           = date_create($citas_hijas[$key+1]->fecha_hora_inicio);
                                                $formato_fecha  = date_format($date,"d-m-Y");
                                            @endphp
                                            {{$formato_fecha}}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(isset($cita->pago))
                        @php
                            $total -= $cita->pago->abono
                        @endphp
                        <tr>
                            <td class="td-proc fuente" align="center">
                                @php
                                    $date           = date_create($cita->fecha_hora_inicio);
                                    $formato_fecha  = date_format($date,"d-m-Y");
                                @endphp
                                {{$formato_fecha}}
                            </td>
                            <td class="td-proc fuente" align="center">
                                @if($total == 0)
                                    <strong>Solvente</strong>
                                @endif
                                @foreach($cita->procedimientos as $procedimientos)
                                    {{$procedimientos->nombre}}
                                @endforeach
                                <br/>
                                {{$cita->descripcion}}
                            </td>
                            <td class="td-proc fuente" align="center">
                                Dr. {{$cita->pago->user->persona->primer_nombre." ".$cita->pago->user->persona->segundo_nombre." ".$cita->pago->user->persona->primer_apellido." ".$cita->pago->user->persona->segundo_apellido}}
                            </td>
                            <td class="td-proc fuente" align="center">
                                
                                $ {{$cita->pago->abono}}
                            </td>
                            <td class="td-proc fuente" align="center">
                                $ {{number_format($total, 2)}}
                            </td>
                            <td class="td-proc fuente" align="center">
                                @if(!$loop->last)
                                    @php
                                        $date           = date_create($citas_hijas[$key+1]->fecha_hora_inicio);
                                        $formato_fecha  = date_format($date,"d-m-Y");
                                    @endphp
                                    {{$formato_fecha}}
                                @endif
                            </td>
                       </tr>
                    @endif
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>