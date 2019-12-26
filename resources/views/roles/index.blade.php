@extends('layouts.base')

@section('titulo')
    Lista de Roles
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
    <h1 align="center" style="color: black">Lista de Roles</h1>
</div>
<div class="table-responsive">
    <table width="100%">
        <tr>
            <td width="80%">
                    <a class="btn btn-sm btn-danger" href="{{route('home')}}""><i class="fas fa-arrow-circle-left"></i> Regresar</a> 
            </td>
            <td width="20%" align="right">
                @can('role.create')
                    <a href="{{route('roles.create')}}" class="btn btn-sm btn-success"  style="color: black"><i class="fas fa-fw fa-clipboard-list"></i> Registrar Rol</a>
                @endcan
            </td>
        </tr>
    </table>
</div>
<br/>
<br/>
<div class="pull-bottom">
    <div class="table table-responsive table-striped">
        <table id="example" class="display" style="width:100%;color: black">
            <thead>
                <tr>
                    <th style="color: black">Rol</th>
                    <th style="color: black">Descripción</th>
                    <th style="color: black">Identificador</th>
                    <th style="color: black">Acciones</th>

                </tr>
            </thead>
            <tbody>
                @foreach($roles as $rol)
                    <tr>
                        <td>{{$rol->name}}</td>
                        <td>{{$rol->description}}</td>
                        <td>{{$rol->slug}}</td>
                        <td>
                            @can('role.show')
                                <a href="{{route('roles.show',['role' => $rol->id])}}" class="btn btn-info btn-circle" title="Ver perfil" ><i class="fas fa-eye"></i></a>
                            @endcan
                            @can('role.edit')
                                <a class="btn btn-primary btn-circle" href="{{route('roles.edit', ['role' => $rol->id])}}"><i class="fas fa-fw fa-pencil-alt"></i></a>
                            @endcan
                            @can('role.destroy')
                                <button type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#modal-default2{{$rol->id}}">
                                    <i class="fas fa-fw fa-trash-alt"></i>
                                </button>
                                <div class="modal fade" id="modal-default2{{$rol->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Eliminar Rol</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form action="{{route('roles.destroy',['role' => $rol->id])}}" method="POST">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <div class="modal-body">
                                                    <h4>Realmente desea eliminar el rol: <strong>{{$rol->name}}</strong>?</h4>
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
                { "orderable": false, "targets": 3 }
            ]
        });
    });
</script>
@endsection