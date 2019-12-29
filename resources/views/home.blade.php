@extends('layouts.base')
@section('titulo')
	Inicio
@endsection
@section('CSS')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>
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
	@if (count($errors) > 0)
		<div class="alert alert-danger" role="alert">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
    {!! $calendar->calendar() !!}

    @can('cita.create')
	<!-- Modal para crear citas a pacientes nuevos-->
	<div class="modal fade" id="nuevo_paciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Reservación de Cita</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form_nuevo" autocomplete="off" method="POST" action="{{route('personas.store')}}" onsubmit="enviarForm('#form_nuevo ')">
					@csrf
					<div class="modal-body">
						<div class="form-group row">
							<label for="primer_nombre" class="col-sm-6 col-form-label">Primer Nombre:<font color="red">*</font></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="primer_nombre" name="primer_nombre" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="segundo_nombre" class="col-sm-6 col-form-label">Segundo Nombre:</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre">
							</div>
						</div>
						<div class="form-group row">
							<label for="primer_apellido" class="col-sm-6 col-form-label">Primer Apellido:<font color="red">*</font></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="primer_apellido" name="primer_apellido" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="segundo_apellido" class="col-sm-6 col-form-label">Segundo Apellido:</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido">
							</div>
						</div>
						<div class="form-group row">
							<label for="telefono" class="col-sm-6 col-form-label">Número de Teléfono:<font color="red">*</font></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="telefono" name="telefono" required>
							</div>
						</div>
						<div class="form-group row">
						    <label for="fecha_hora_inicio_1" class="col-sm-6 col-form-label">Fecha y hora de inicio:<font color="red">*</font></label>
						    <div class="col-sm-6">
					            <input id="fecha_hora_inicio_1" type='datetime-local' class="form-control" name="fecha_hora_inicio" value="{{ old('fecha_hora_inicio') }}" required />
						      	@if ($errors->has('fecha_hora_inicio'))
									<span class="help-block">
										<strong>{{ $errors->first('fecha_hora_inicio') }}</strong>
									</span>
								@endif
						    </div>
						</div>
						<div class="form-group row">
						    <label for="fecha_hora_fin_1" class="col-sm-6 col-form-label">Fecha y hora de finalización:<font color="red">*</font></label>
						    <div class="col-sm-6">
						      	<input id="fecha_hora_fin_1" type="datetime-local" class="form-control" name="fecha_hora_fin" value="{{ old('fecha_hora_fin') }}">
						      	@if ($errors->has('fecha_hora_fin'))
									<span class="help-block">
										<strong>{{ $errors->first('fecha_hora_fin') }}</strong>
									</span>
								@endif
						    </div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12" align="center" style="display: block">
								<button type="button" class="btn btn-outline-success" onclick="addProcedimiento({{$listado_procedimientos}})" style="width: 100%">Añadir procedimiento</button>
							</div>
						</div>
						<div id="procedimientos_create"></div>
						<div class="form-group row">
						    <label for="descripcion_1" class="col-sm-6 col-form-label">Descripción:</label>
						    <div class="col-sm-6">
						      	<textarea id="descripcion_1"  class="form-control" name="descripcion">{{ old('descripcion') }}</textarea>
								@if ($errors->has('descripcion'))
									<span class="help-block">
										<strong>{{ $errors->first('descripcion') }}</strong>
									</span>
								@endif
						    </div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Modal crear cita a pacientes antiguos-->
	<div class="modal fade" id="antiguo_paciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Reservación de Cita</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form_antiguo" autocomplete="off" method="POST" action="{{route('citas.store')}}" onsubmit="enviarForm('#form_antiguo ')">
					@csrf
					<div class="modal-body">
						<div class="form-group row">
							<label for="numero_expediente" class="col-sm-6 col-form-label">Número de Expediente:<font color="red">*</font></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="numero_expediente" name="numero_expediente" required>
							</div>
						</div>
						<div class="form-group row">
						    <label for="fecha_hora_inicio_2" class="col-sm-6 col-form-label">Fecha y hora de inicio:<font color="red">*</font></label>
						    <div class="col-sm-6">
					            <input id="fecha_hora_inicio_2" type='datetime-local' class="form-control" name="fecha_hora_inicio" value="{{ old('fecha_hora_inicio') }}" required />
						      	@if ($errors->has('fecha_hora_inicio'))
									<span class="help-block">
										<strong>{{ $errors->first('fecha_hora_inicio') }}</strong>
									</span>
								@endif
						    </div>
						</div>
						<div class="form-group row">
						    <label for="fecha_hora_fin_2" class="col-sm-6 col-form-label">Fecha y hora de finalización:<font color="red">*</font></label>
						    <div class="col-sm-6">
						      	<input id="fecha_hora_fin_2" type="datetime-local" class="form-control" name="fecha_hora_fin" value="{{ old('fecha_hora_fin') }}">
						      	@if ($errors->has('fecha_hora_fin'))
									<span class="help-block">
										<strong>{{ $errors->first('fecha_hora_fin') }}</strong>
									</span>
								@endif
						    </div>
						</div>
						
						<div class="form-group row">
							<div class="col-sm-12" align="center" style="display: block">
								<button type="button" class="btn btn-outline-success" onclick="addProcedimiento({{$listado_procedimientos}},1)" style="width: 100%">Añadir procedimiento</button>
							</div>
						</div>
						<div id="procedimientos_create"></div>
						<div class="form-group row">
						    <label for="descripcion_2" class="col-sm-6 col-form-label">Descripción:</label>
						    <div class="col-sm-6">
						      	<textarea id="descripcion_2"  class="form-control" name="descripcion">{{ old('descripcion') }}</textarea>
								@if ($errors->has('descripcion'))
									<span class="help-block">
										<strong>{{ $errors->first('descripcion') }}</strong>
									</span>
								@endif
						    </div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endcan

	@can('cita.show')
	<!-- Modal Detalles de cita -->
	<div class="modal fade" id="showCita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document" >
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Detalles de Cita</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form>
					<div class="modal-body">
						<input type="hidden" name="cita" value="" readonly disabled>
						<div class="form-group row">
						    <label for="nombre_completo" class="col-sm-6 col-form-label">Paciente:</label>
						    <div class="col-sm-6">
					            <input id="nombre_completo" type='text' class="form-control" name="nombre_completo" value="" readonly disabled />
						    </div>
						</div>
						<div class="form-group row">
						    <label for="fecha_hora_inicio_3" class="col-sm-6 col-form-label">Fecha y hora de inicio:</label>
						    <div class="col-sm-6">
					            <input id="fecha_hora_inicio_3" type='datetime-local' class="form-control" name="fecha_hora_inicio" value="" readonly disabled />
						    </div>
						</div>
						<div class="form-group row">
						    <label for="fecha_hora_fin_3" class="col-sm-6 col-form-label">Fecha y hora de finalización:</label>
						    <div class="col-sm-6">
						      	<input id="fecha_hora_fin_3" type="datetime-local" class="form-control" name="fecha_hora_fin" value="" readonly disabled>
						    </div>
						</div>
						<div id="div_procedimientos"></div>
						<div class="form-group row">
						    <label for="descripcion_3" class="col-sm-6 col-form-label">Descripción:</label>
						    <div class="col-sm-6">
						      	<textarea id="descripcion_3"  class="form-control" readonly disabled></textarea>
						    </div>
						</div>
					</div>
					<div class="table-responsive">
						<table width="100%">
							<tr>
								<td>
									<div class="modal-footer">
										<button type="button" class="btn btn-outline-secondary" data-dismiss="modal" data-toggle="modal" onclick="$('#showCita').on('hidden.bs.modal',function(e){ $('#showCita').modal('hide');$('#page-top').removeClass('modal-open') });">
											<i class="far fa-times-circle"></i> Cerrar Detalles
										</button>
										@can('cita.edit')
											<button type="button" class="btn btn-outline-success"   onclick="$('#editCita').modal('show').on('shown.bs.modal',function(e){  });">
												<i class="fas fa-pencil-alt"></i> Editar Cita
											</button>
											<button type="button" class="btn btn-outline-info"   onclick="$('#reprogramarCita').modal('show').on('shown.bs.modal',function(e){  });">
												<i class="fas fa-calendar-times"></i> Reprogramar Cita
											</button>
										@endcan
										<div id="botones" class="btn-group">
											@can('cita.create')
												<div id="btn_seguimiento"></div>
											@endcan
											@can('expediente.create')
												<div id="btn_expediente"></div>
											@endcan
											@can('pago.index')
												<div id="btn_pago"></div>
											@endcan
											@can('receta.index')
												<div id="btn_receta"></div>
											@endcan
										</div>
										@can('cita.destroy')
											<button type="button" class="btn btn-outline-danger" onclick="$('#eliminarCita').modal('show').on('shown.bs.modal',function(e){  });">
												<i class="fas fa-trash-alt"></i> Eliminar Cita
											</button>
										@endcan
									</div>	
								</td>		
							</tr>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endcan

	@can('cita.edit')
		<!-- Modal -->
		<div class="modal fade" id="editCita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Editar Cita</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="form_editar" method="POST" onsubmit="enviarForm('#form_editar ')" action="">
						@csrf
						{{method_field('PUT')}}
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-12" align="center" style="display: block">
									<button type="button" class="btn btn-outline-success" onclick="addProcedimiento({{$listado_procedimientos}},2)" style="width: 100%">Añadir procedimiento</button>
								</div>
							</div>
							<div id="procedimientos_create"></div>
							<div class="form-group row">
								<label for="edit_descripcion" class="col-sm-6 col-form-label">Descripción:</label>
								<div class="col-sm-6">
									<textarea id="edit_descripcion"  class="form-control" name="descripcion"></textarea>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table width="100%">
								<tr>
									<td>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" onclick="$('#editCita').modal('hide').on('hidden.bs.modal',function(e){ $('#page-top').addClass('modal-open') });">
												<i class="far fa-times-circle"></i> Cancelar
											</button>
											<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
										</div>	
									</td>		
								</tr>
							</table>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Modal para reprogramar una cita -->
		<div class="modal fade" id="reprogramarCita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Reprogramar Cita</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="form_reprogramar" method="POST" action="">
						@csrf
						{{method_field('PUT')}}
						<div class="modal-body">
							<div class="form-group row">
							    <label for="edit_fecha_hora_inicio" class="col-sm-6 col-form-label">Fecha y hora de inicio:</label>
							    <div class="col-sm-6">
						            <input id="edit_fecha_hora_inicio" type='datetime-local' class="form-control" name="fecha_hora_inicio" value=""/>
							    </div>
							</div>
							<div class="form-group row">
							    <label for="edit_fecha_hora_fin" class="col-sm-6 col-form-label">Fecha y hora de finalización:</label>
							    <div class="col-sm-6">
							      	<input id="edit_fecha_hora_fin" type="datetime-local" class="form-control" name="fecha_hora_fin" value="">
							    </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" onclick="$('#reprogramarCita').modal('hide').on('hidden.bs.modal',function(e){ $('#page-top').addClass('modal-open') });">
								<i class="far fa-times-circle"></i> Cancelar
							</button>
							<button type="submit" class="btn btn-success"><i class="fas fa-calendar-check"></i> Reprogramar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endcan
	@can('cita.destroy')
		<!-- Modal para eliminar una cita -->
		<div class="modal fade" id="eliminarCita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Eliminar Cita</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>
							Realmente desea eliminar la cita del paciente: 
						</p>
						<p>
							<strong><label id="label_paciente"></label></strong>
						</p>
						<p>
							hora de inicio: <strong><label id="label_hora_inicio"></label></strong>
						</p>
						<p>
							hora de fin: <strong><label id="label_hora_fin"></label></strong>
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" onclick="$('#eliminarCita').modal('hide').on('hidden.bs.modal',function(e){ $('#page-top').addClass('modal-open') });">
							<i class="far fa-times-circle"></i> Cancelar
						</button>
						<form id="form_eliminar" method="POST" action="">
							@csrf
							{{method_field('DELETE')}}
							<button type="submit" class="btn btn-success"><i class="fas fa-trash-alt"></i> Eliminar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endcan
	@can('cita.create')
		<!-- Modal crear cita a pacientes antiguos-->
		<div class="modal fade" id="proximaCita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Reservación de proxima cita</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="form_seguimiento" autocomplete="off" method="POST" action="{{route('citas.store')}}" onsubmit="enviarForm('#form_seguimiento ')">
						@csrf
						<div class="modal-body">
							<div class="form-group row">
							    <label for="fecha_hora_inicio_4" class="col-sm-6 col-form-label">Fecha y hora de inicio:<font color="red">*</font></label>
							    <div class="col-sm-6">
						            <input id="fecha_hora_inicio_4" type='datetime-local' class="form-control" name="fecha_hora_inicio" value="" required />
							      	@if ($errors->has('fecha_hora_inicio'))
										<span class="help-block">
											<strong>{{ $errors->first('fecha_hora_inicio') }}</strong>
										</span>
									@endif
							    </div>
							</div>
							<div class="form-group row">
							    <label for="fecha_hora_fin_4" class="col-sm-6 col-form-label">Fecha y hora de finalización:<font color="red">*</font></label>
							    <div class="col-sm-6">
							      	<input id="fecha_hora_fin_4" type="datetime-local" class="form-control" name="fecha_hora_fin" value="">
							      	@if ($errors->has('fecha_hora_fin'))
										<span class="help-block">
											<strong>{{ $errors->first('fecha_hora_fin') }}</strong>
										</span>
									@endif
							    </div>
							</div>
							
							<div class="form-group row">
								<div class="col-sm-12" align="center" style="display: block">
									<button type="button" class="btn btn-outline-success" onclick="addProcedimiento({{$listado_procedimientos}},3)" style="width: 100%">Añadir procedimiento</button>
								</div>
							</div>
							<div id="procedimientos_create"></div>
							<div class="form-group row">
							    <label for="descripcion_4" class="col-sm-6 col-form-label">Descripción:</label>
							    <div class="col-sm-6">
							      	<textarea id="descripcion_4"  class="form-control" name="descripcion">{{ old('descripcion') }}</textarea>
									@if ($errors->has('descripcion'))
										<span class="help-block">
											<strong>{{ $errors->first('descripcion') }}</strong>
										</span>
									@endif
							    </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" onclick="$('#proximaCita').modal('hide').on('hidden.bs.modal',function(e){ $('#page-top').addClass('modal-open') });">Cerrar</button>
							<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endcan
@endsection
@section('JS')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    {!! $calendar->script() !!}
    <script type="text/javascript">
    	$(function(){
    		$('.fc-paciente_nuevo-button').click( function() {
    			$('#fecha_hora_inicio_1').attr("value","");
    			$('#fecha_hora_fin_1').attr("value","");
    			$('#nuevo_paciente').modal();
    		});
    		$('.fc-paciente_antiguo-button').click( function() {
    			$('#fecha_hora_inicio_2').attr("value","");
    			$('#fecha_hora_fin_2').attr("value","");
    			$('#antiguo_paciente').modal()
    		});
			$('#telefono').mask('X000-0000',{ translation: { 'X': { pattern: /(2|7|6)/, optional: false } } })
			$('#telefono').attr('placeholder','####-####')
			$('#numero_expediente').mask('X000-0000',{ translation: { 'X': { pattern: /([A-Z])/, optional: false } } })
			$('#numero_expediente').attr('placeholder','X###-####')
			$('#fecha_hora_fin_1').attr('disabled',true)
			$('#fecha_hora_inicio_1').change(function(){
				if($('#fecha_hora_inicio_1').val() != ""){
					$('#fecha_hora_fin_1').attr('disabled',false).attr('min',$(this).val()).val($(this).val());
				}else{
					$('#fecha_hora_fin_1').attr('disabled',true).attr('min',$(this).val()).val("")
				}
			});
			$('#fecha_hora_fin_2').attr('disabled',true)
			$('#fecha_hora_inicio_2').change(function(){
				if($('#fecha_hora_inicio_2').val() != ""){
					$('#fecha_hora_fin_2').attr('disabled',false).attr('min',$(this).val()).val($(this).val());
				}else{
					$('#fecha_hora_fin_2').attr('disabled',true).attr('min',$(this).val()).val("")
				}
			});

			$('#fecha_hora_fin_4').attr('disabled',true)
			$('#fecha_hora_inicio_4').change(function(){
				if($('#fecha_hora_inicio_4').val() != ""){
					$('#fecha_hora_fin_4').attr('disabled',false).attr('min',$(this).val()).val($(this).val());
				}else{
					$('#fecha_hora_fin_4').attr('disabled',true).attr('min',$(this).val()).val("")
				}
			});
    	})
    </script>
    <script src="{{asset('js/modales/GestionProcedimientoCita.js')}}"></script>
@endsection