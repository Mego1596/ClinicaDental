@extends('layouts.base')

@section('titulo')
    Lista de Planes de Tratamiento
@endsection
@section('content')
@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
@if (\Session::has('danger'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('danger') !!}</li>
        </ul>
    </div>
@endif
<div class="panel-title">
    <h1 align="center" style="color: black">Lista de Planes de Tratamiento</h1>
</div>
<div class="table-responsive">
    <table width="100%">
        <tr>
            <td width="100%">
                <a class="btn btn-sm btn-danger" href="{{route('expedientes.index')}}"><i class="fas fa-arrow-circle-left"></i> Regresar</a> 
            </td>
        </tr>
    </table>
</div>
<br/>
<br/>
<div class="pull-bottom">
    <div class="table-responsive">
    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Numero de Plan</th>
                <th>Planes de Tratamiento</th>
                <th>Odontograma</th>
                
            </tr>
        </thead>
        <tbody>
            @php
                $x=0;
            @endphp
            @foreach($citas as $cita)
                @can('cita.index')
                <tr>
                    <td align="center">
                        @php
                            $date=date_create($cita->fecha_hora_inicio);
                            echo date_format($date,"d/m/Y");
                        @endphp
                    </td>
                    <td align="right">
                        @php
                            echo ++$x;
                        @endphp
                    </td>
                    <td align="center">    
                        <a href="{{ route('expedientes.plan',['cita' => $cita->id])}}" class="btn btn-sm btn-info" style="color: white" target="_blank"><li class="fa fa-file-pdf-o"></li> Ver Plan de Tratamiento
                    </td>
                    <td align="center">
                        @if($loop->last)
                            @if(sizeof($cita->odontogramas) == 0)
                                @can('odontograma.create')
                                    <a href="{{ route('odontogramas.tratamiento',['cita' => $cita->id])}}" class="btn btn-circle btn-primary" style="color: white"><li class="fas fa-tooth"></li>
                                @endcan
                            @else
                                @can('odontograma.destroy')
                                    @foreach($cita->odontogramas as $odontograma)
                                        @if($odontograma->activo == 1)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#eliminarOdontograma">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="eliminarOdontograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Eliminar odontograma</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3>Esta seguro que desea eliminar este odontograma?</h3>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <form method="POST" action="{{route('odontogramas.destroy',['odontograma' => $odontograma->id])}}">
                                                                @csrf
                                                                {{method_field('DELETE')}}
                                                                <button type="submit" class="btn btn-danger">Si</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @if($loop->last)
                                                @can('odontograma.create')
                                                    <a href="{{ route('odontogramas.tratamiento',['cita' => $cita->id])}}" class="btn btn-circle btn-primary" style="color: white"><li class="fas fa-tooth"></li>
                                                @endcan
                                            @endif
                                        @endif
                                    @endforeach
                                @endcan
                            @endif
                        @endif
                    </td>
                </tr>
                @endcan
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection

@section('JS')
<script type="text/javascript">
    $(function () {
        $('#example').DataTable({
            "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            responsive:true,
            pagingType: "simple",
            "columnDefs": [
                { "orderable": false, "targets": [2,3] }
            ]
        });
        
    });
</script>
@endsection