@extends('layouts.base')

@section('titulo')
Registrar Paciente
@endsection

@section('content')
<h1 style="text-align: center;"><strong>Registrar Paciente</strong></h1>
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
<form autocomplete="off" method="POST" action="{{ route('expedientes.store') }}">
	@csrf
	<input type="hidden" name="especial" id="especial" value="especial">
	<input type="hidden" name="persona" id="persona" value="{{$persona->id}}">
	<div class="form-group row col-sm-12">
		<label for="fecha_nacimiento" class="col-sm-2 col-form-label">Fecha de nacimiento:<font color="red">*</font></label>
		<div class="col-sm-4">
			<input id="fecha_nacimiento" type="date" class="form-control" max="{{Carbon\Carbon::now()->subYears(1)->format('Y-m-d')}}" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
			@if ($errors->has('fecha_nacimiento'))
			<span class="help-block">
				<strong>{{ $errors->first('fecha_nacimiento') }}</strong>
			</span>
			@endif
		</div>
		<label for="sexo" class="col-sm-2 col-form-label">Género:<font color="red">*</font></label>
		<div class="col-sm-4">
			<select class="form-control" name="sexo" required>
				<option value="" selected disabled>Seleccione un género</option>
				<option value="M">Masculino</option>
				<option value="F">Femenino</option>
			</select>
		</div>
	</div>
	<div class="form-group row col-sm-12">
		<label for="responsable" class="col-sm-2 col-form-label">Responsable:</label>
		<div class="col-sm-4">
			<input id="responsable" type="text" class="form-control" name="responsable" value="{{ old('responsable') }}">
			@if ($errors->has('responsable'))
			<span class="help-block">
				<strong>{{ $errors->first('responsable') }}</strong>
			</span>
			@endif
		</div>
		<label for="ocupacion" class="col-sm-2 col-form-label">Ocupación:<font color="red">*</font></label>
		<div class="col-sm-4">
			<select class="form-control" name="ocupacion" required>
				<option value="" selected disabled>Seleccione una ocupación</option>
				<option value="Estudiante">Estudiante</option>
				<option value="Empleado">Empleado</option>
				<option value="Ama de casa">Ama de casa</option>
				<option value="Desempleado">Desempleado</option>
				<option value="Otros">Otros</option>
			</select>
		</div>
	</div>
	<div class="form-group row col-sm-12">
		<label for="direccion" class="col-sm-2 col-form-label">Domicilio:<font color="red">*</font></label>
		<div class="col-sm-4">
			<textarea id="direccion" class="form-control" name="direccion" rows="4" required>{{ old('direccion') }}</textarea>
			@if ($errors->has('direccion'))
			<span class="help-block">
				<strong>{{ $errors->first('direccion') }}</strong>
			</span>
			@endif
		</div>
		<label for="direccion_trabajo" class="col-sm-2 col-form-label">Direccion de trabajo:</label>
		<div class="col-sm-4">
			<textarea id="direccion_trabajo" class="form-control" name="direccion_trabajo" rows="4">{{ old('direccion_trabajo') }}</textarea>
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
			<textarea id="historia_odontologica" class="form-control" name="historia_odontologica" rows="4">{{ old('historia_odontologica') }}</textarea>
			@if ($errors->has('historia_odontologica'))
			<span class="help-block">
				<strong>{{ $errors->first('historia_odontologica') }}</strong>
			</span>
			@endif
		</div>
		<label for="historia_medica" class="col-sm-2 col-form-label">Historia Medica:</label>
		<div class="col-sm-4">
			<textarea id="historia_medica" class="form-control" name="historia_medica" rows="4">{{ old('historia_medica') }}</textarea>
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
			<input id="recomendado" type="text" class="form-control" name="recomendado" value="{{ old('recomendado') }}">
			@if ($errors->has('recomendado'))
			<span class="help-block">
				<strong>{{ $errors->first('recomendado') }}</strong>
			</span>
			@endif
		</div>
		<label for="email" class="col-sm-2 col-form-label">E-Mail:</label>
		<div class="col-sm-4">
			<input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
		</div>
	</div>
	<div class="d-flex justify-content-center">
		<button class="btn btn-success" style="margin-right: 1%"><i class="fa fa-save"></i> Guardar</button>
		<a href="{{route('expedientes.index')}}" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Cancelar</a>
	</div>
</form>


@endsection

@section('JS')
<script type="text/javascript">
	$(document).ready(function() {
		$('#telefono').mask('X000-0000', {
			translation: {
				'X': {
					pattern: /(2|7|6)/,
					optional: false
				}
			}
		})
		$('#telefono').attr('placeholder', '####-####')
	})
</script>
@endsection