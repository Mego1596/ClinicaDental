@extends('layouts.base')

@section('titulo')
    Detalles del Paciente
@endsection

@section('content')
<h1 style="text-align: center;"><strong>Detalles del Paciente</strong></h1>
<form>
	<div class="form-group row col-sm-12">
	    <label for="primer_nombre" class="col-sm-2 col-form-label">Primer nombre:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="primer_nombre" value="{{ $expediente->persona->primer_nombre }}" readonly disabled>
	      	@if ($errors->has('primer_nombre'))
				<span class="help-block">
					<strong>{{ $errors->first('primer_nombre') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="segundo_nombre" class="col-sm-2 col-form-label">Segundo nombre:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="segundo_nombre" value="{{ $expediente->persona->segundo_nombre }}" readonly disabled>
	      	@if ($errors->has('segundo_nombre'))
				<span class="help-block">
					<strong>{{ $errors->first('segundo_nombre') }}</strong>
				</span>
			@endif
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="primer_apellido" class="col-sm-2 col-form-label">Primer apellido:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="primer_apellido" value="{{ $expediente->persona->primer_apellido }}" readonly disabled>
	      	@if ($errors->has('primer_apellido'))
				<span class="help-block">
					<strong>{{ $errors->first('primer_apellido') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="segundo_apellido" class="col-sm-2 col-form-label">Segundo apellido:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="segundo_apellido" value="{{ $expediente->persona->segundo_apellido }}" readonly disabled>
	      	@if ($errors->has('segundo_apellido'))
				<span class="help-block">
					<strong>{{ $errors->first('segundo_apellido') }}</strong>
				</span>
			@endif
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="telefono" class="col-sm-2 col-form-label">Número de Teléfono<font color="red">*</font></label>
	    <div class="col-sm-4">
	      	<input id="telefono" type="text" class="form-control" name="telefono" value="{{ $expediente->persona->telefono }}" readonly disabled>
			@if ($errors->has('telefono'))
				<span class="help-block">
					<strong>{{ $errors->first('telefono') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="email" class="col-sm-2 col-form-label">E-Mail:</label>
	    <div class="col-sm-4">
	    	@if(!is_null($expediente->persona->user))
	      		<input type="email" class="form-control" id="email" name="email" value="{{$expediente->persona->user->email}}" readonly disabled>
	      	@else
	      		<input type="email" class="form-control" id="email" name="email" readonly disabled>
	      	@endif
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="fecha_nacimiento" class="col-sm-2 col-form-label">Fecha de nacimiento:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      	<input id="fecha_nacimiento" type="date" class="form-control" max="{{Carbon\Carbon::now()->subYears(1)->format('Y-m-d')}}" name="fecha_nacimiento" value="{{ $expediente->fecha_nacimiento }}" readonly disabled>
			@if ($errors->has('fecha_nacimiento'))
				<span class="help-block">
					<strong>{{ $errors->first('fecha_nacimiento') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="sexo" class="col-sm-2 col-form-label">Género:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      <select class="form-control" name="sexo" readonly disabled>
	      	<option value="" disabled>Seleccione un género</option>
	      	@if($expediente->sexo == 'M')
	      		<option value="M" selected>Masculino</option>
	      		<option value="F">Femenino</option>
	      	@else
	      		<option value="M">Masculino</option>
	      		<option value="F" selected>Femenino</option>
	      	@endif
	      </select>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="responsable" class="col-sm-2 col-form-label">Responsable:</label>
	    <div class="col-sm-4">
	      	<input id="responsable" type="text" class="form-control" name="responsable" value="{{ $expediente->responsable }}" readonly disabled>
			@if ($errors->has('responsable'))
				<span class="help-block">
					<strong>{{ $errors->first('responsable') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="ocupacion" class="col-sm-2 col-form-label" >Ocupación:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      <select class="form-control" name="ocupacion" readonly disabled>
	      	<option value="" disabled>Seleccione una ocupación</option>
	      	@if($expediente->ocupacion == 'Estudiante')
		      	<option value="Estudiante" selected>Estudiante</option>
		      	<option value="Empleado">Empleado</option>
		      	<option value="Ama de casa">Ama de casa</option>
		      	<option value="Desempleado">Desempleado</option>
		      	<option value="Otros">Otros</option>
		    @endif
		    @if($expediente->ocupacion == 'Empleado')
		      	<option value="Estudiante">Estudiante</option>
		      	<option value="Empleado" selected>Empleado</option>
		      	<option value="Ama de casa">Ama de casa</option>
		      	<option value="Desempleado">Desempleado</option>
		      	<option value="Otros">Otros</option>
		    @endif
		    @if($expediente->ocupacion == 'Ama de casa')
		      	<option value="Estudiante">Estudiante</option>
		      	<option value="Empleado">Empleado</option>
		      	<option value="Ama de casa" selected>Ama de casa</option>
		      	<option value="Desempleado">Desempleado</option>
		      	<option value="Otros">Otros</option>
		    @endif
		    @if($expediente->ocupacion == 'Desempleado')
		      	<option value="Estudiante">Estudiante</option>
		      	<option value="Empleado">Empleado</option>
		      	<option value="Ama de casa">Ama de casa</option>
		      	<option value="Desempleado" selected>Desempleado</option>
		      	<option value="Otros">Otros</option>
		    @endif
		    @if($expediente->ocupacion == 'Otros')
		      	<option value="Estudiante">Estudiante</option>
		      	<option value="Empleado">Empleado</option>
		      	<option value="Ama de casa">Ama de casa</option>
		      	<option value="Desempleado">Desempleado</option>
		      	<option value="Otros" selected>Otros</option>
		    @endif
	      </select>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="direccion" class="col-sm-2 col-form-label">Domicilio:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      	<textarea id="direccion" class="form-control" name="direccion" rows="4" readonly disabled>{{ $expediente->persona->direccion }}</textarea>
			@if ($errors->has('direccion'))
				<span class="help-block">
					<strong>{{ $errors->first('direccion') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="direccion_trabajo" class="col-sm-2 col-form-label">Direccion de trabajo:</label>
	    <div class="col-sm-4">
	      	<textarea id="direccion_trabajo" class="form-control" name="direccion_trabajo" rows="4" readonly disabled>{{ $expediente->direccion_trabajo }}</textarea>
			@if ($errors->has('direccion_trabajo'))
				<span class="help-block">
					<strong>{{ $errors->first('direccion_trabajo') }}</strong>
				</span>
			@endif
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="historia_odontologica" class="col-sm-2 col-form-label">Historia Odontologica:</label>
	    <div class="col-sm-4">
	      	<textarea id="historia_odontologica" class="form-control" name="historia_odontologica" rows="4" readonly disabled>{{ $expediente->historia_odontologica }}</textarea>
			@if ($errors->has('historia_odontologica'))
				<span class="help-block">
					<strong>{{ $errors->first('historia_odontologica') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="historia_medica" class="col-sm-2 col-form-label">Historia Medica:</label>
	    <div class="col-sm-4">
	        <textarea id="historia_medica" class="form-control" name="historia_medica" rows="4" readonly disabled>{{ $expediente->historia_medica }}</textarea>
			@if ($errors->has('historia_medica'))
				<span class="help-block">
					<strong>{{ $errors->first('historia_medica') }}</strong>
				</span>
			@endif
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="recomendado" class="col-sm-2 col-form-label">Recomendado por:</label>
	    <div class="col-sm-4">
	      	<input id="recomendado" type="text" class="form-control" name="recomendado" value="{{ $expediente->recomendado }}" readonly disabled>
			@if ($errors->has('recomendado'))
				<span class="help-block">
					<strong>{{ $errors->first('recomendado') }}</strong>
				</span>
			@endif
	    </div>
	</div>
	<div class="d-flex justify-content-center">
		<a href="{{route('expedientes.index')}}" class="btn btn-danger"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
		
	</div>
</form>
@endsection