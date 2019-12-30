@extends('layouts.base')

@section('titulo')
    Lista de Planes de Tratamiento
@endsection
@section('content')
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
                <th>Numero de Plan</th>
                <th>Planes de Tratamiento</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @php
                $x=0;
            @endphp
            @foreach($citas as $cita)
                @can('pacientes.trabajo')
                <tr>
                    <td align="right">
                        @php
                            echo ++$x;
                        @endphp
                    </td>
                    <td align="center">    
                        <a href="{{ route('expedientes.plan',['cita' => $cita->id])}}" class="btn btn-sm btn-info" style="color: white" target="_blank"><li class="fa fa-file-pdf-o"></li> Ver Plan de Tratamiento
                    </td>
                    <td>
                        @php
                            $date=date_create($cita->created_at);
                            echo date_format($date,"d/m/Y");
                        @endphp
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
                { "orderable": false, "targets": 1 }
            ]
        });
        
    });
</script>
@endsection