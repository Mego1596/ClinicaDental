@extends('layouts.base')
@section('titulo')
	Receta
@endsection

@section('content')
	<h1 style="text-align: center;"><strong>Receta</strong></h1>
	    <div class="table-responsive">
			<table width="100%">
				<tr>
					<td width="80%">
					        <a class="btn btn-sm btn-danger" href="{{route('home')}}""><i class="fas fa-arrow-circle-left"></i> Regresar</a> 
					</td>
					<td width="20%" align="right">
				        @can('receta.create')
				            <a href="{{route('citas.recetas.create',['cita' => $cita->id])}}" class="btn btn-sm btn-success"  style="color: black;"><i class="fas fa-fw fa-clipboard-list"></i> Registrar Receta</a>
				        @endcan
					</td>
				</tr>
			</table>
		</div>
@endsection