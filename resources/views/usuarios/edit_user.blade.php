@extends('layouts.base')

@section('titulo')
Editar Usuario
@endsection

@section('content')
<h1 style="text-align: center;"><strong>Editar Usuario</strong></h1>
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
<form autocomplete="off" method="POST" action="{{ route('users.update',['user'=> $user->id]) }}">
	@csrf
	{{method_field('PUT')}}
	<div class="form-group row col-sm-12">
		<label for="primer_nombre" class="col-sm-2 col-form-label">Primer nombre:</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="primer_nombre" value="{{ $user->persona->primer_nombre }}" required>
			@if ($errors->has('primer_nombre'))
			<span class="help-block">
				<strong>{{ $errors->first('primer_nombre') }}</strong>
			</span>
			@endif
		</div>
		<label for="segundo_nombre" class="col-sm-2 col-form-label">Segundo nombre:</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="segundo_nombre" value="{{ $user->persona->segundo_nombre }}">
			@if ($errors->has('segundo_nombre'))
			<span class="help-block">
				<strong>{{ $errors->first('segundo_nombre') }}</strong>
			</span>
			@endif
		</div>
	</div>
	<div class="form-group row col-sm-12">
		<label for="primer_apellido" class="col-sm-2 col-form-label">Primer apellido:</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="primer_apellido" value="{{ $user->persona->primer_apellido }}" required>
			@if ($errors->has('primer_apellido'))
			<span class="help-block">
				<strong>{{ $errors->first('primer_apellido') }}</strong>
			</span>
			@endif
		</div>
		<label for="segundo_apellido" class="col-sm-2 col-form-label">Segundo apellido:</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="segundo_apellido" value="{{ $user->persona->segundo_apellido }}">
			@if ($errors->has('segundo_apellido'))
			<span class="help-block">
				<strong>{{ $errors->first('segundo_apellido') }}</strong>
			</span>
			@endif
		</div>
	</div>
	<div class="form-group row col-sm-12">
		<label for="telefono" class="col-sm-2 col-form-label">Número de Teléfono:</label>
		<div class="col-sm-4">
			<input id="telefono" type="text" class="form-control" name="telefono" value="{{ $user->persona->telefono }}" required>
			@if ($errors->has('telefono'))
			<span class="help-block">
				<strong>{{ $errors->first('telefono') }}</strong>
			</span>
			@endif
		</div>
		<label for="email" class="col-sm-2 col-form-label">E-Mail</label>
		<div class="col-sm-4">
			<input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" required>
		</div>
	</div>
	<div class="form-group row col-sm-12">
		<label for="direccion" class="col-sm-2 col-form-label">Direccion:</label>
		<div class="col-sm-4">
			<textarea id="direccion" class="form-control" name="direccion" rows="4" required>{{ $user->persona->direccion }}</textarea>
			@if ($errors->has('direccion'))
			<span class="help-block">
				<strong>{{ $errors->first('direccion') }}</strong>
			</span>
			@endif
		</div>

		<label for="role" class="col-sm-2">Tipo de Usuario:</label>
		<div class="col-sm-4">
			<select required class="form-control" name="role" id="role" style="padding: -100%" required>
				<option value="" disabled selected>Seleccione el tipo de usuario</option>
				@foreach($roles as $rol)
				@if($user->roles[0]['slug'] == $rol->slug)
				<option value="{{$rol->slug}}" selected>{{$rol->name}}</option>
				@else
				<option value="{{$rol->slug}}">{{$rol->name}}</option>
				@endif
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group row col-sm-12">
		<label id="label_junta" for="numero_junta" class="col-sm-2" style="display: none">Número de Junta:</label>
		<div class="col-sm-4" id="div_junta" style="display: none">
			<input id="numero_junta" type="text" class="form-control" name="numero_junta" value="{{ $user->persona->numero_junta }}">
			@if ($errors->has('numero_junta'))
			<span class="help-block">
				<strong>{{ $errors->first('numero_junta') }}</strong>
			</span>
			@endif
		</div>
	</div>

	<div class="d-flex justify-content-center">
		<button class="btn btn-success" style="margin-right: 1%"><i class="fa fa-save"></i> Guardar</button>
		<a href="{{route('users.index')}}" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Cancelar</a>
	</div>
</form>


@endsection

@section('JS')
<script type="text/javascript">
	$(function() {
		$('#telefono').mask('X000-0000', {
			translation: {
				'X': {
					pattern: /(2|7|6)/,
					optional: false
				}
			}
		})
		$('#telefono').attr('placeholder', '####-####')
		$('#numero_junta').mask('JVPO-#')
		if ($('#role').val() == 'doctor' || $('#role').val() == 'asistente') {
			$('#label_junta').css('display', 'block');
			$('#div_junta').css('display', 'block');
			$('#numero_junta').attr('required', true);
		} else {
			$('#label_junta').css('display', 'none');
			$('#div_junta').css('display', 'none');
			$('#numero_junta').attr('required', false);
		}
		$('#role').change(function() {
			if ($(this).val() == 'doctor' || $('#role').val() == 'asistente') {
				$('#label_junta').css('display', 'block');
				$('#div_junta').css('display', 'block');
				if ($('#role').val() == 'asistente') {
					$('#numero_junta').attr('required', false);
				} else {
					$('#numero_junta').attr('required', true);
				}
			} else {
				$('#label_junta').css('display', 'none');
				$('#div_junta').css('display', 'none');
				$('#numero_junta').attr('required', false);
			}
		});
	})
</script>
@endsection