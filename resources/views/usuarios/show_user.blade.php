@extends('layouts.base')

@section('titulo')
    Detalles de Usuario
@endsection

@section('content')
<h1 style="text-align: center;"><strong>Detalles de Usuario</strong></h1>
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
<form>
	<div class="form-group row col-sm-12">
	    <label for="primer_nombre" class="col-sm-2 col-form-label">Primer nombre:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="primer_nombre" value="{{ $user->persona->primer_nombre }}" readonly disabled>
	    </div>
	    <label for="segundo_nombre" class="col-sm-2 col-form-label">Segundo nombre:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="segundo_nombre" value="{{ $user->persona->segundo_nombre }}" readonly disabled>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="primer_apellido" class="col-sm-2 col-form-label">Primer apellido:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="primer_apellido" value="{{ $user->persona->primer_apellido }}" readonly disabled>
	    </div>
	    <label for="segundo_apellido" class="col-sm-2 col-form-label">Segundo apellido:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="segundo_apellido" value="{{ $user->persona->segundo_apellido }}" readonly disabled>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="telefono" class="col-sm-2 col-form-label">Número de Teléfono:</label>
	    <div class="col-sm-4">
	      	<input id="telefono" type="text" class="form-control" name="telefono" value="{{ $user->persona->telefono }}" readonly disabled>
	    </div>
	    <label for="email" class="col-sm-2 col-form-label">E-Mail</label>
	    <div class="col-sm-4">
	      <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" readonly disabled>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="direccion" class="col-sm-2 col-form-label">Direccion:</label>
	    <div class="col-sm-4">
	      	<textarea id="direccion" class="form-control" name="direccion" rows="4" readonly disabled>{{ $user->persona->direccion }}</textarea>
			@if ($errors->has('direccion'))
				<span class="help-block">
					<strong>{{ $errors->first('direccion') }}</strong>
				</span>
			@endif
	    </div>

	    <label for="role" class="col-sm-2" >Tipo de Usuario:</label>
		<div class="col-sm-4">
	      	<select required class="form-control" name="role" id="role" style="padding: -100%" readonly disabled>
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
	      	<input id="numero_junta" type="text" class="form-control" name="numero_junta" value="{{ $user->persona->numero_junta }}" readonly disabled>
			@if ($errors->has('numero_junta'))
				<span class="help-block">
					<strong>{{ $errors->first('numero_junta') }}</strong>
				</span>
			@endif
	    </div>
	</div>

	<div class="d-flex justify-content-center">
		<a href="{{route('users.index')}}" class="btn btn-danger"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
	</div>
</form>


@endsection

@section('JS')
<script type="text/javascript">
	$(document).ready(function(){
		$('#telefono').mask('0000-0000')
		$('#telefono').attr('placeholder','####-####')
		if($('#role').val() == 'doctor'){
			$('#label_junta').css('display','block');
			$('#div_junta').css('display','block');
		}
	})
</script>
@endsection