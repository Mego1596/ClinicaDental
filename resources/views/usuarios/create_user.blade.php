@extends('layouts.base')

@section('titulo')
    Registrar Usuario
@endsection

@section('content')
<h1 style="text-align: center;"><strong>Registrar Usuario</strong></h1>
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
<form autocomplete="off" method="POST" action="{{ route('users.store') }}">
	@csrf
	<div class="form-group row col-sm-12">
	    <label for="primer_nombre" class="col-sm-2 col-form-label">Primer nombre:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="primer_nombre" value="{{ old('primer_nombre') }}" required>
	      	@if ($errors->has('primer_nombre'))
				<span class="help-block">
					<strong>{{ $errors->first('primer_nombre') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="segundo_nombre" class="col-sm-2 col-form-label">Segundo nombre:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="segundo_nombre" value="{{ old('segundo_nombre') }}">
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
	      	<input type="text" class="form-control" name="primer_apellido" value="{{ old('primer_apellido') }}" required>
	      	@if ($errors->has('primer_apellido'))
				<span class="help-block">
					<strong>{{ $errors->first('primer_apellido') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="segundo_apellido" class="col-sm-2 col-form-label">Segundo apellido:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="segundo_apellido" value="{{ old('segundo_apellido') }}">
	      	@if ($errors->has('segundo_apellido'))
				<span class="help-block">
					<strong>{{ $errors->first('segundo_apellido') }}</strong>
				</span>
			@endif
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="telefono" class="col-sm-2 col-form-label">Número de Teléfono:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      	<input id="telefono" type="text" class="form-control" name="telefono" value="{{ old('telefono') }}" required>
			@if ($errors->has('telefono'))
				<span class="help-block">
					<strong>{{ $errors->first('telefono') }}</strong>
				</span>
			@endif
	    </div>
	    <label for="email" class="col-sm-2 col-form-label">E-Mail:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="direccion" class="col-sm-2 col-form-label">Direccion:<font color="red">*</font></label>
	    <div class="col-sm-4">
	      	<textarea id="direccion" class="form-control" name="direccion" rows="4" required>{{ old('direccion') }}</textarea>
			@if ($errors->has('direccion'))
				<span class="help-block">
					<strong>{{ $errors->first('direccion') }}</strong>
				</span>
			@endif
	    </div>

	    <label for="role" class="col-sm-2" >Tipo de Usuario:<font color="red">*</font></label>
		<div class="col-sm-4">
	      	<select required class="form-control" name="role" id="role" style="padding: -100%" required>
				<option value="" disabled selected>Seleccione el tipo de usuario</option>
				@foreach($roles as $rol)
					<option value="{{$rol->slug}}">{{$rol->name}}</option>
				@endforeach
			</select>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label id="label_junta" for="numero_junta" class="col-sm-2" style="display: none">Número de Junta:</label>
		<div class="col-sm-4" id="div_junta" style="display: none">
	      	<input id="numero_junta" type="text" class="form-control" name="numero_junta" value="{{ old('numero_junta') }}">
			@if ($errors->has('numero_junta'))
				<span class="help-block">
					<strong>{{ $errors->first('numero_junta') }}</strong>
				</span>
			@endif
	    </div>
	</div>

	<div class="d-flex justify-content-center">
		<button class="btn btn-success" style="margin-right: 1%"><i class="far fa-save"></i> Guardar</button>
		<a href="{{route('users.index')}}" class="btn btn-danger"><i class="fas fa-arrow-circle-left"></i> Cancelar</a>
	</div>
</form>


@endsection

@section('JS')
<script type="text/javascript">
	$(document).ready(function(){
		$('#telefono').mask('X000-0000',{ translation: { 'X': { pattern: /(2|7|6)/, optional: false } } })
		$('#numero_junta').mask('JVPO-#')
		$('#telefono').attr('placeholder','####-####')
		if($('#role').val() == 'doctor' || $('#role').val() == 'asistente'){
			$('#label_junta').css('display','block');
			$('#div_junta').css('display','block');
			$('#numero_junta').attr('required',true);
		}else{
			$('#label_junta').css('display','none');
			$('#div_junta').css('display','none');
			$('#numero_junta').attr('required',false);
		}
		$('#role').change(function(){
			if($(this).val() == 'doctor' || $('#role').val() == 'asistente'){
				$('#label_junta').css('display','block');
				$('#div_junta').css('display','block');
				if($('#role').val() == 'asistente'){
					$('#numero_junta').attr('required',false);
				}else{
					$('#numero_junta').attr('required',true);
				}
			}else{
				$('#label_junta').css('display','none');
				$('#div_junta').css('display','none');
				$('#numero_junta').attr('required',false);
			}
		});
	})
</script>
@endsection