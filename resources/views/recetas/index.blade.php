@extends('layouts.base')
@section('titulo')
	Receta
@endsection

@section('content')
	<h1 style="text-align: center;"><strong>Receta</strong></h1>
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
    @if(isset($cita->receta))
	    <div class="table-responsive">
			<table width="100%">
				<tr>
					<td width="30%">
					        <a class="btn btn-sm btn-danger" href="{{route('home')}}""><i class="fas fa-arrow-circle-left"></i> Regresar</a> 
					</td>
					<td width="40%" align="center">
						@can('receta.show')
							<a class="btn btn-sm btn-info" href="{{route('citas.recetas.show',['receta' => $cita->receta->id,'cita'=>$cita->id])}}" target="_blank">
				        		<i class="fas fa-file-pdf"></i> Generar PDF
				        	</a>
				        @endcan
					</td>
					@if(sizeof($cita->receta->detalle_receta) < 2)
						<td width="10%" align="right">
					        @can('receta.create')
					            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#crearRecetaDetalle">
						        	<i class="fas fa-fw fa-clipboard-list"></i> Asignar Detalles
						        </button>
								<!-- Modal -->
								<div class="modal fade" id="crearRecetaDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-md" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Asignar Detalles de Receta</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form method="POST" autocomplete="off" action="{{route('recetas.detalles.store',['receta' => $cita->receta->id])}}">
												@csrf
												<div class="modal-body">
													<div class="form-group row">
													    <label for="medicamento" class="col-sm-6 col-form-label">Medicamento:</label>
													    <div class="col-sm-6">
												            <input id="medicamento" type='text' class="form-control" name="medicamento" value="{{old('medicamento')}}" required />
													    </div>
													</div>
													<div class="form-group row">
													    <label for="dosis" class="col-sm-6 col-form-label">Dosis:</label>
													    <div class="col-sm-6">
												            <input id="dosis" type='text' class="form-control" name="dosis" value="{{old('dosis')}}" required/>
													    </div>
													</div>
													<div class="form-group row">
													    <label for="cantidad" class="col-sm-6 col-form-label">Cantidad:</label>
													    <div class="col-sm-6">
												            <input id="cantidad" type='text' class="form-control" name="cantidad" value="{{old('cantidad')}}" required/>
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
						</td>
						<td width="10%" align="right">
							@can('receta.edit')
								<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editarReceta">
						        	<i class="fa fa-pencil"></i> Editar Receta
						        </button>
						    @endcan
					    </td>
					    <td width="10%" align="right">
					    	@can('receta.destroy')
						        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default-eliminar-receta">
						        	<i class="fas fa-trash-alt"></i> Eliminar Receta
						        </button>
					       	@endcan
						</td>
					@else
						<td width="21%" align="right">
							@can('receta.edit')
								<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editarReceta">
						        	<i class="fa fa-pencil"></i> Editar Receta
						        </button>
						    @endcan
					    </td>
					    <td width="9%" align="right">
					        @can('receta.destroy')
						        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default-eliminar-receta">
						        	<i class="fas fa-trash-alt"></i> Eliminar Receta
						        </button>
					       	@endcan
						</td>
					@endif
					@can('receta.edit')
						<!-- Modal para editar de detalles de receta -->
						<div class="modal fade bd-example-modal-md" id="modalEditDetalle" tabindex="-1" role="dialog" aria-labelledby="modalDetalleLabel" aria-hidden="true">
						    <div class="modal-dialog modal-md" role="document">
						        <div class="modal-content">
						            <div class="modal-header">
						                <h5 class="modal-title" id="modalDetalleLabel">Editar detalle de la receta</h5>
						                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                    <span aria-hidden="true">&times;</span>
						                </button>
						            </div>
						            <form id="formularioEdicion" role="form" method="POST" action="" autocomplete="off">
						                <div class="modal-body">
						                    @csrf
						                    {{method_field('PUT')}}
						                    <div class="form-group row {{ $errors->has('medicamento') ? ' has-error' : '' }}">
						                        <label for="medicamento_edit" class="col-sm-4 col-form-label">Medicamento:</label>
						                        <div class="col-sm-8">
						                            <input id="medicamento_edit" type="text" class="form-control" name= "medicamento" required>
						                            @if ($errors->has('medicamento'))
						                                <span class="help-block">
						                                    <strong>{{ $errors->first('medicamento') }}</strong>
						                                </span>
						                            @endif
						                        </div>
						                    </div>
						                    <div class="form-group row {{ $errors->has('dosis') ? ' has-error' : '' }}">
						                        <label for="dosis_edit" class="col-sm-4 col-form-label">Dosis:</label>
						                        <div class="col-sm-8">
						                            <input id="dosis_edit" type="text" name="dosis" class="form-control" required/>
						                            @if ($errors->has('dosis'))
						                                <span class="help-block">
						                                    <strong>{{ $errors->first('dosis') }}</strong>
						                                </span>
						                            @endif
						                        </div>
						                    </div>
						                    <div class="form-group row {{ $errors->has('cantidad') ? ' has-error' : '' }}">
						                        <label for="cantidad_edit" class="col-sm-4 col-form-label">Cantidad:</label>
						                        <div class="col-sm-8">
						                            <input id="cantidad_edit" type="text" name= "cantidad" class="form-control" required/>
						                            @if ($errors->has('cantidad'))
						                                <span class="help-block">
						                                    <strong>{{ $errors->first('cantidad') }}</strong>
						                                </span>
						                            @endif
						                        </div>
						                    </div>
						                </div>
						                <div class="modal-footer">
						                	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						                	<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
						                </div>
						            </form>
						        </div>
						    </div>
						</div>
						<!-- Modal -->
						<div class="modal fade bd-example-modal-md" id="editarReceta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-md" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Editar Receta</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form method="POST" autocomplete="off" action="{{route('citas.recetas.update',['cita' => $cita->id,'receta' => $cita->receta->id])}}">
										@csrf
										{{method_field('PUT')}}
										<div class="modal-body">
											<div class="form-group row">
											    <label for="peso_form" class="col-sm-6 col-form-label">Peso:</label>
											    <div class="col-sm-6">
										            <input id="peso_form" type='number' step="0.10" class="form-control" name="peso" value="{{$cita->receta->peso}}" required />
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
			        @can('receta.destroy')
                        <!-- Modal -->
						<div class="modal fade bd-example-modal-md" id="modal-default-eliminar-receta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-md" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Eliminar receta</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form method="POST" autocomplete="off" action="{{ route('citas.recetas.destroy',['cita'=>$cita->id,'receta' => $cita->receta->id]) }}">
										@csrf
										{{method_field('DELETE')}}
										<div class="modal-body">
											Realmente desea eliminar la receta?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
											<button type="submit" class="btn btn-danger"> Si</button>
										</div>	
									</form>
								</div>
							</div>
						</div>
                    @endcan
				</tr>
			</table>
		</div>
		@php
			$date=date_create($cita->receta->create_at);
			$aux= date_format($date,"d/m/Y");
		@endphp
		<h1 style="text-align: center;"><strong>{{$aux}}</strong></h1>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group row col-sm-12">
					<label for="nombre" class="col-sm-2 col-form-label">Nombre Completo:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="nombre" value="{{$cita->persona->primer_nombre.' '.$cita->persona->segundo_nombre.' '.$cita->persona->primer_apellido.' '.$cita->persona->segundo_apellido}}" readonly disabled>
					</div>
					<label for="peso" class="col-sm-2 col-form-label">Peso:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="peso" value="{{$cita->receta->peso}}" readonly disabled>
					</div>
				</div>	
				<div class="table-responsive">
					<table class="display table-hovered table-striped" width="100%">
						<tr>
							<th>Medicamento</th>
							<th>Dosis</th>
							<th>Cantidad</th>
							<th>Acciones</th>
						</tr>
						@if(sizeof($cita->receta->detalle_receta) != 0)
							@foreach($cita->receta->detalle_receta as $detalle)
								<tr>
									<td width="25%">{{$detalle->medicamento}}</td>
									<td width="25%">{{$detalle->dosis}}</td>
									<td width="25%">{{$detalle->cantidad}}</td>
									<td width="25%">
										@can('receta.edit')
											<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalEditDetalle" onclick="selectDetalle({{$cita->receta->id}},{{ $detalle->id }},'{{ $detalle->medicamento }}','{{ $detalle->dosis }}','{{ $detalle->cantidad }}');" title="Detalles de la receta"><i class="fa fa-pencil"></i> Editar</button>
										@endcan
										@can('receta.destroy')
		    	                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modal-default-{{$detalle->id}}">
		    	                                <i class="fas fa-fw fa-trash-alt"></i> Eliminar
		    	                            </button>

			    	                        <!-- Modal -->
											<div class="modal fade bd-example-modal-md" id="modal-default-{{$detalle->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-md" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Eliminar detalle de receta</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<form method="POST" autocomplete="off" action="{{ route('recetas.detalles.destroy',['receta'=>$cita->receta->id,'detalles' => $detalle->id]) }}">
															@csrf
															{{method_field('DELETE')}}
															<div class="modal-body">
																Realmente desea eliminar el medicamento:<strong>{{$detalle->medicamento}}</strong>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
																<button type="submit" class="btn btn-danger"> Si</button>
															</div>	
														</form>
													</div>
												</div>
											</div>
		    	                        @endcan
									</td>
								</tr>
							@endforeach
						@endif
					</table>
				</div>							
			</div>
		</div>
	@else
		<div class="table-responsive">
			<table width="100%">
				<tr>
					<td width="80%">
					        <a class="btn btn-sm btn-danger" href="{{route('home')}}""><i class="fas fa-arrow-circle-left"></i> Regresar</a> 
					</td>
					<td width="20%" align="right">
				        @can('receta.create')
				            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#crearReceta" style="color: black">
					        	<i class="fas fa-fw fa-clipboard-list"></i> Registrar Receta
					        </button>
				        @endcan
					</td>
				</tr>
			</table>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="crearReceta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Registrar Receta</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="POST" autocomplete="off" action="{{route('citas.recetas.store',['cita' => $cita->id])}}">
						@csrf
						<div class="modal-body">
							<div class="form-group row">
							    <label for="peso_form" class="col-sm-6 col-form-label">Peso:</label>
							    <div class="col-sm-6">
						            <input id="peso_form" type='number' step="0.10" class="form-control" name="peso" value="{{old('peso')}}" required />
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
	@endif
@endsection
@section('JS')
<script src="{{asset('js/modales/GestionReceta.js')}}"></script>
@endsection