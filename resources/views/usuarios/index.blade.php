@extends('layouts.base')

@section('titulo')
    Lista de Usuarios
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
    <h1 align="center" style="color: black">Lista de Usuarios</h1>
</div>
<div class="row">
    <div class="col-sm-9">
        <a class="btn btn-sm btn-danger" href="{{route('home')}}"><i class="fas fa-arrow-circle-left"></i> Regresar</a> 
    </div>
    <div class="col-sm-3" align="right">
        @can('user.create')
            <a href="{{route('users.create')}}" class="btn btn-sm btn-success" style="color: black;"><i class="fa fa-fw fa-user-plus"></i> Registrar Usuario</a>
        @endcan
    </div>
</div>
<br/>
<br/>
<div class="pull-bottom">
    <div class="table table-responsive">
        <table id="example" class="display" style="width:100%;color: black">
            <thead>
                <tr>
                    <th style="color: black">Nombre Completo</th>
                    <th style="color: black">Correo Electrónico</th>
                    <th style="color: black">Número de Teléfono</th>
                    <th style="color: black">Acciones</th>
                </tr>
            </thead>
            <tbody>
            	@foreach($users as $datos)
	                <tr>
	                    <td>{{$datos->primer_nombre.' '.$datos->segundo_nombre.' '.$datos->primer_apellido.' '.$datos->segundo_apellido}}</td>
	                    <td>{{$datos->email}}</td>
	                    <td>{{$datos->name}}</td>
	                    <td>
	                        @can('user.show')
	                            <a href="{{route('users.show',['user'=>$datos->id])}}" class="btn btn-info btn-circle" title="Ver perfil" style="color: white"><i class="fa fa-eye"></i></a>
	                        @endcan
	                        @can('user.edit')
	                            <a href="{{route('users.edit',['user'=>$datos->id])}}" class="btn btn-primary btn-circle" title="Registrar Recepción de Vehículo" style="color: white" ><i class="fas fa-pencil-alt"></i></a>
	                        @endcan
	                        @can('user.destroy')
	                            <button type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#modal-default2{{$datos->id}}">
	                                <i class="fas fa-fw fa-trash-alt"></i>
	                            </button>
	                        @endcan
	                        <div class="modal fade" id="modal-default2{{$datos->id}}">
	                            <div class="modal-dialog">
	                                <div class="modal-content">
	                                    <div class="modal-header">
	                                        <h4>Eliminar Usuario</h4>
	                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                                        <span aria-hidden="true">&times;</span></button>
	                                    </div>
	                                    <form action="{{ route('users.destroy',['user'=>$datos->id]) }}" method="POST">
	                                        @csrf
	                                        <input type="hidden" name="_method" value="DELETE">
	                                        <div class="modal-body">
	                                            <h4>Realmente desea eliminar el usuario: <strong>{{$datos->primer_nombre.' '.$datos->segundo_nombre.' '.$datos->primer_apellido.' '.$datos->segundo_apellido}}</strong>?</h4>
	                                        </div>
	                                        <div class="modal-footer">
	                                            <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Cerrar</button>
	                                            <button type="submit" class="btn btn-danger">Si</button>
	                                        </div>
	                                    </form>
	                                </div>
	                            </div>
	                        </div>
	                    </td>
	                </tr>
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
            pagingType: "simple"
        });
    });
</script>
@endsection