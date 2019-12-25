@extends('layouts.base')
@section('titulo')
	Inicio
@endsection
@section('CSS')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>
@endsection
@section('content')
    {!! $calendar->calendar() !!}

	<!-- Modal -->
	<div class="modal fade" id="nuevo_paciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Reservación de Cita</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form autocomplete="off" method="POST">
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
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="antiguo_paciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Reservación de Cita</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form autocomplete="off" method="POST" action="">
					@csrf
					<div class="modal-body">
						<div class="form-group row">
							<label for="numero_expediente" class="col-sm-6 col-form-label">Número de Expediente:<font color="red">*</font></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="numero_expediente" name="numero_expediente" required>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success"><i class="fa fa-arrow-circle-right"></i> Continuar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@section('JS')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    {!! $calendar->script() !!}
    <script type="text/javascript">
    	$(function(){
    		$('.fc-paciente_nuevo-button').click( function() {
    			$('#nuevo_paciente').modal();
    		});
    		$('.fc-paciente_antiguo-button').click( function() {
    			$('#antiguo_paciente').modal();
    		});
			$('#telefono').mask('X000-0000',{ translation: { 'X': { pattern: /(2|7|6)/, optional: false } } })
			$('#telefono').attr('placeholder','####-####')
			$('#numero_expediente').mask('X000-0000',{ translation: { 'X': { pattern: /([A-Z])/, optional: false } } })
			$('#numero_expediente').attr('placeholder','X###-####')
    	})
    </script>
@endsection