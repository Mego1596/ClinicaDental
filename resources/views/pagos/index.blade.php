@extends('layouts.base')

@section('titulo')
	Pago
@endsection

@section('content')
	<h1 style="text-align: center;"><strong>Pago</strong></h1>
	@if (\Session::has('success'))
	    <div class="alert alert-success">
	        <ul>
	            <li>{!! \Session::get('success') !!}</li>
	        </ul>
	    </div>
	@endif
	@if (count($errors) > 0)
		<div class="alert alert-danger" role="alert">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	@if(session()->has('danger'))
		<div class="alert alert-danger" role="alert">{{session('danger')}}</div>
	@endif

	@if(isset($cita->pago))
		<div class="table-responsive">
			<table width="100%">
				<tr>
					<td width="70%">
					    <a class="btn btn-sm btn-danger" href="{{route('home')}}""><i class="fas fa-arrow-circle-left"></i> Regresar</a> 
					</td>
					<td width="30%" align="right">
						@can('pago.edit')
				            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default-editar-pago">
					        	<i class="fas fa-pencil-alt"></i> Editar 
					        </button>
				        @endcan
					</td>
				</tr>
			</table>
		</div>
		@can('pago.edit')
			<!-- Modal -->
			<div class="modal fade bd-example-modal-md" id="modal-default-editar-pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Editar Pago</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" autocomplete="off" action="{{route('citas.pagos.update',['cita' => $cita->id,'pago' => $cita->pago->id])}}">
							@csrf
							{{method_field('PUT')}}
							<div class="modal-body">
								<div class="form-group row">
									<input type="hidden" name="total_plan" class="form-control" id="total_plan_edit" value="{{$total}}" required>
								    <label for="abono_edit" class="col-sm-6 col-form-label">Abono:</label>
								    <div class="col-sm-6">
								      	<input type="number" step="0.01" min="0" name="abono" class="form-control" id="abono_edit" value="{{$cita->pago->abono}}" required>
								    </div>
								</div>
								<div class="form-group row">
								    <label for="user" class="col-sm-6 col-form-label">Doctor Asignado:</label>
								    <div class="col-sm-6">
								    	<select id="user" name="user" class="form-control" required>
								    		<option value="">Seleccione el doctor</option>
								    		@foreach($users as $user)
								    			@if($cita->pago->user_id == $user->id)
								    				<option value="{{$user->id}}" selected>Dr.{{$user->primer_nombre.' '.$user->segundo_nombre.' '.$user->primer_apellido.' '.$user->segundo_apellido}}</option>
								    			@else
								    				<option value="{{$user->id}}">Dr.{{$user->primer_nombre.' '.$user->segundo_nombre.' '.$user->primer_apellido.' '.$user->segundo_apellido}}</option>
								    			@endif
								    		@endforeach
								    	</select>
								    </div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
								<button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
							</div>	
						</form>
					</div>
				</div>
			</div>
        @endcan
    	<div class="table-responsive">
			<table class="display table-hovered table-striped" width="100%">
				<tr>
					<th>Fecha</th>
					<th>Realizo el tratamiento</th>
					<th>Abono</th>
				</tr>
				<tr>
					<td width="25%">{{$cita->pago->created_at}}</td>
					<td width="25%">Dr. {{$cita->pago->user->persona->primer_nombre." ".$cita->pago->user->persona->segundo_nombre." ".$cita->pago->user->persona->primer_apellido." ".$cita->pago->user->persona->segundo_apellido}}</td>
					<td width="25%">{{$cita->pago->abono}}</td>
				</tr>
			</table>
		</div>
	@else
		<div class="table-responsive">
			<table width="100%">
				<tr>
					<td width="80%">
					       <a class="btn btn-sm btn-danger" href="{{route('home')}}""><i class="fas fa-arrow-circle-left"></i> Regresar</a> 
					</td>
					<td width="20%" align="right">
				        @can('pago.create')
				            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#crearPago" style="color: black">
					        	<i class="fas fa-hand-holding-usd"> <font size="1px"><i class="fa fa-plus"></i></i></font> Registrar Pago
					        </button>
				        @endcan
					</td>
				</tr>
			</table>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="crearPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Crear Pago</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form autocomplete="off" method="POST" action="{{route('citas.pagos.store',['cita' => $cita->id])}}">
						@csrf
						<div class="modal-body">

							<input type="hidden" name="total_plan" class="form-control" id="total_plan" value="{{$total}}" required>
	
							<div class="form-group row">
							    <label for="abono" class="col-sm-6 col-form-label">Abono:</label>
							    <div class="col-sm-6">
							      	<input type="number" step="0.01" min="0" name="abono" class="form-control" id="abono" value="{{old('abono')}}" required>
							    </div>
							</div>
							<div class="form-group row">
							    <label for="user" class="col-sm-6 col-form-label">Doctor Asignado:</label>
							    <div class="col-sm-6">
							    	<select id="user" name="user" class="form-control" required>
							    		<option value="">Seleccione el doctor</option>
							    		@foreach($users as $user)
							    			<option value="{{$user->id}}">Dr.{{$user->primer_nombre.' '.$user->segundo_nombre.' '.$user->primer_apellido.' '.$user->segundo_apellido}}</option>
							    		@endforeach
							    	</select>
							    </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Cerrar</button>
							<button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endif
	<div class="d-flex justify-content-center">
		<table>
			<tr>
				<td>
					<h3>
						Total a pagar: <strong>{{round($total,2)}}</strong>
					</h3>
				</td>
			</tr>
			<tr>
				<td align="center">
					@if($total == 0)
						<p><h3>Solvente</h3></p>
					@endif
				</td>
			</tr>
		</table>
	</div>
@endsection

@section('JS')
<script type="text/javascript">
	$(function(){
		$('#abono').attr('max',$('#total_plan').val())

		$('#crearPago').on('shown.bs.modal',function(e){
			$('#abono').val('');
		})
	})
</script>
@endsection