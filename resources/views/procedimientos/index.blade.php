@extends('layouts.base')

@section('titulo')
    Lista de Procedimientos
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
    <h1 align="center" style="color: black">Lista de Procedimientos</h1>
</div>
<div class="table-responsive">
    <table width="100%">
        <tr>
            <td width="90%">
                    <a class="btn btn-sm btn-danger" href="{{route('home')}}""><i class="fas fa-arrow-circle-left"></i> Regresar</a> 
            </td>
            <td width="10%">
                @can('procedimiento.create')
                    <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalProcedimiento" style="color: black"><i class="fas fa-clipboard-list"></i> Registrar Procedimiento</a>
                @endcan
            </td>
        </tr>
    </table>
</div>
<br/>
<br/>
<div class="pull-bottom">
    <div class="table table-responsive">
        <table id="example" class="display" style="width:100%;color: black">
            <thead>
                <tr>
                    <th style="color: black">Nombre</th>
                    <th style="color: black">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($procedimientos as $datos)
                    <tr>
                        <td>{{$datos->nombre}}</td>
                        <td>
                            @can('procedimiento.show')
                                <a class="btn btn-info btn-circle" data-toggle="modal" data-target="#modalEditProcedimiento" 
                                onclick="selectProcedimiento({{$datos->id}},'{{$datos->nombre}}','{{$datos->descripcion}}',0);" title="Detalles del Procedimiento"><i class="fas fa-eye" style="color: white"></i></a> 
                            @endcan
                            @can('procedimiento.edit')
                                <a class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modalEditProcedimiento" 
                                onclick="selectProcedimiento({{$datos->id}},'{{$datos->nombre}}','{{$datos->descripcion}}');" title="Editar Procedimiento"><i class="fas fa-pencil-alt" style="color: white"></i></a> 
                            @endcan
                            @can('procedimiento.destroy')
                                <button type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#modal-default{{$datos->id}}">
                                    <i class="fas  fa-trash-alt"></i>
                                </button>
                                <div class="modal fade" id="modal-default{{$datos->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Eliminar Procedimiento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form action="{{route('procedimientos.destroy',['procedimiento' => $datos->id])}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <div class="modal-body">
                                                    <h4>Realmente desea eliminar el procedimiento: <strong>{{$datos->nombre}}</strong>?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary pull-left" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-sm btn-danger">Si</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Modal para editar de procedimiento -->
<div class="modal fade bd-example-modal-lg" id="modalEditProcedimiento" tabindex="-1" role="dialog" aria-labelledby="modalProcedimientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProcedimientoLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formularioEdicion" role="form" method="POST" action="" autocomplete="off">
                <div class="modal-body">
                    @csrf
                    {{method_field('PUT')}}
                    <div class="form-group row {{ $errors->has('nombre') ? ' has-error' : '' }}">
                        <label for="nombre_edit" class="col-sm-4 col-form-label">Nombre del Procedimiento:</label>
                        <div class="col-sm-8">
                            <input id="nombre_edit" type="text" class="form-control" name= "nombre" value="{{ old('nombre') }}" required>
                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="descripcion_edit" class="col-sm-4 col-form-label">Descripción:</label>
                        <div class="col-sm-8">
                            <textarea id="descripcion_edit" name= "descripcion" class="form-control" rows="5" required>{{ old('descripcion') }}</textarea>
                            @if ($errors->has('descripcion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('descripcion') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para registro de procedimiento -->
<div class="modal fade bd-example-modal-lg" id="modalProcedimiento" tabindex="-1" role="dialog" aria-labelledby="modalProcedimientoLabell" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProcedimientoLabell">Registrar Procedimiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('procedimientos.store') }}" autocomplete="off">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row {{ $errors->has('nombre') ? ' has-error' : '' }}">
                        <label for="nombre" class="col-sm-4 col-form-label">Nombre del Procedimiento:</label>
                        <div class="col-sm-8">
                            <input id="nombre" type="text" class="form-control" name= "nombre" value="{{ old('nombre') }}" required>
                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('descripcion') ? ' has-error' : '' }}">
                        <label for="descripcion" class="col-sm-4 col-form-label">Descripción:</label>
                        <div class="col-sm-8">
                            <textarea id="descripcion" name= "descripcion" class="form-control" rows="5" required>{{ old('descripcion') }}</textarea>
                            @if ($errors->has('descripcion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('descripcion') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('JS')
<script src="{{asset('js/modales/modalEditarProcedimiento.js')}}"></script>
<script type="text/javascript">
    $(document).ready( function () {
        $('#example').DataTable({
            "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            responsive:true,
            pagingType:'simple',
            "columnDefs": [
                { "orderable": false, "targets": 1 }
            ]
        });
    });
</script>
@endsection