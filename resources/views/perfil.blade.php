@extends('layouts.base')

@section('titulo')
	Perfíl de Usuario
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
	<h1 style="text-align: center;"><strong>Perfíl de Usuario</strong></h1>
	<div class="form-group row col-sm-12">
	    <label for="primer_nombre" class="col-sm-2 col-form-label">Primer nombre:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="primer_nombre" value="{{ Auth::user()->persona->primer_nombre }}" readonly disabled>
	    </div>
	    <label for="segundo_nombre" class="col-sm-2 col-form-label">Segundo nombre:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="segundo_nombre" value="{{ Auth::user()->persona->segundo_nombre }}" readonly disabled>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="primer_apellido" class="col-sm-2 col-form-label">Primer apellido:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="primer_apellido" value="{{ Auth::user()->persona->primer_apellido }}" readonly disabled>
	    </div>
	    <label for="segundo_apellido" class="col-sm-2 col-form-label">Segundo apellido:</label>
	    <div class="col-sm-4">
	      	<input type="text" class="form-control" name="segundo_apellido" value="{{ Auth::user()->persona->segundo_apellido }}" readonly disabled>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="telefono" class="col-sm-2 col-form-label">Número de Teléfono:</label>
	    <div class="col-sm-4">
	      	<input id="telefono" type="text" class="form-control" name="telefono" value="{{ Auth::user()->persona->telefono }}" readonly disabled>
	    </div>
	    <label for="email" class="col-sm-2 col-form-label">E-Mail</label>
	    <div class="col-sm-4">
	      <input type="email" class="form-control" id="email" name="email" value="{{Auth::user()->email}}" readonly disabled>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="direccion" class="col-sm-2 col-form-label">Direccion:</label>
	    <div class="col-sm-4">
	      	<textarea id="direccion" class="form-control" name="direccion" rows="4" readonly disabled>{{ Auth::user()->persona->direccion }}</textarea>
			@if ($errors->has('direccion'))
				<span class="help-block">
					<strong>{{ $errors->first('direccion') }}</strong>
				</span>
			@endif
	    </div>

	    <label for="role" class="col-sm-2" >Tipo de Usuario:</label>
		<div class="col-sm-4">
	      	<input type="text" name="role" readonly disabled value="{{Auth::user()->roles[0]['description']}}" class="form-control">
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    <label for="numero_junta" class="col-sm-2">Número de Junta:</label>
		<div class="col-sm-4">
	      	<input id="numero_junta" type="text" class="form-control" name="numero_junta" value="{{ Auth::user()->persona->numero_junta }}" readonly disabled>
	    </div>
	    <label for="name" class="col-sm-2">Nombre de usuario:</label>
		<div class="col-sm-4">
	      	<input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" readonly disabled>
	    </div>
	</div>
	<div class="form-group row col-sm-12">
	    @if(Auth::user()->roles[0]['slug'] == 'paciente')
		    <label for="fecha_nacimiento" class="col-sm-2">Fecha de Nacimiento:</label>
			<div class="col-sm-4">
		      	<input id="fecha_nacimiento" type="text" class="form-control" name="fecha_nacimiento" value="{{ Auth::user()->persona->expediente->fecha_nacimiento }}" readonly disabled>
		    </div>
	    @endif
	</div>
	<div class="d-flex justify-content-center">
		<a href="{{route('home')}}" class="btn btn-danger"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cambioContrasena" style="margin-left: 0.7%">
		  <i class="fas fa-fw fa-lock"></i> Cambiar Contraseña
		</button>
	</div>

	<div class="modal fade" id="cambioContrasena" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      	<div class="modal-dialog modal-md" role="document">
        	<div class="modal-content">
         		<div class="modal-header">
            		<h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
            		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              			<span aria-hidden="true">&times;</span>
            		</button>
          		</div>
          		<form method="POST" action="{{route('cambio_contrasena')}}">
          			@csrf
	          		<div class="modal-body">
	          			<div class="form-group row col-sm-12">
                            <label for="password" class="col-sm-6 col-form-label">{{ __('Password') }} Actual:</label>
                            <div class="col-sm-6">
                                <input id="password" type="password" class="form-control" name="old_password" required>
                            </div>
                        </div>
						<div class="form-group row col-sm-12">
                            <label for="password" class="col-sm-6 col-form-label">Nueva {{ __('Password') }}:</label>
                            <div class="col-sm-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="form-group row col-sm-12">
                            <label for="password-confirm" class="col-sm-6 col-form-label">{{ __('Confirm Password') }}:</label>
                            <div class="col-sm-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
	          		</div>
	          		<div class="modal-footer">
	            		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	            		<button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
	          		</div>
      			</form>
        	</div>
      	</div>
    </div>
@endsection