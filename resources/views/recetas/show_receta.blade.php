<!DOCTYPE html>
<html>
<head>
	<title>Receta</title>
</head>
<body>
<div>
	<table border="0" cellspacing="0" cellpadding="0">
	 <tr>
	 <td>
	    <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 100px">
	          <tr>
	            <td>
	            	<img src="img/yekipaki1.jpg" alt="Trulli" width="80" height="70">
	            </td>
	            <td>
	            	<table border="0" cellspacing="0" cellpadding="0" style="font-size: 20px">
	            		<tr>
	            			<td>CLINÍCA DENTAL DE ATENCION</td>
	            		</tr>
	            		<tr>
	            			<td align="center">INTEGRAL Y PREVENTIVA</td>
	            		</tr>
	            		<tr style="font-size: 25px;font-family: serif;color: #00b3f2">
	            			<td align="center">"@include('layouts.nombreEmpresa')"</td>
	            		</tr>
	        		</table>
	        	</td>
	            <td>            
	            	<img src="img/yekipaki2.jpg" alt="Trulli" width="60" height="80">
	            </td>
	          </tr>
	    </table>    
	 </td>
	 </tr>
	</table>
</div>
<div style="background: #7ed7f7;margin-top: 10px ; width: 100% ;height: 5px"></div>
<div align="center">
	Col.Libertad Av.Washington #414, San Salvador Telefonos: 2102-2198-6420-8735
</div>
<br/>
<div>
	<table>
		<tr>
			<td><label style="font-size: 15px; font-style: italic;">Paciente:</label></td>
			<td><label style="text-decoration: underline;font-size: 15px"> {{$cita->persona->primer_nombre." ".$cita->persona->segundo_nombre." ".$cita->persona->primer_apellido." ".$cita->persona->segundo_apellido}}</label></td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>	
			<td><label style="font-size: 15px; font-style: italic;">Edad:</label></td>
			<td><label style="text-decoration: underline;font-size: 15px">{{$edad}}</label></td>
		</tr>
		<tr>
			<td><label style="font-size: 15px; font-style: italic;">Peso:</label></td>
			<td><label style="text-decoration: underline;font-size: 15px"> {{$receta->peso}} lbs.</label></td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>
			<td style="color: white;">.</td>	
			<td><label style="font-size: 15px; font-style: italic;">Fecha:</label></td>
			<td><label style="text-decoration: underline;font-size: 15px">{{$newDate}}</label></td>
		</tr>
		<tr>
			<td><label style="font-size: 15px; font-style: italic;">Rp.</label></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0">
	 <tr>
	 <td>
	    <table border="0" cellspacing="0" cellpadding="0" width="500px">
	        @if(sizeof($detalles) != 0)
		        @if(sizeof($detalles) == 2)
		        	@foreach($detalles as $proc)
			        	<tr>
			            	<td>{{$proc->medicamento}}</td>
			          	</tr>
			          	<tr>
			          		<td>{{$proc->dosis}}</td>
			          	</tr>
			          	<tr>
			          		<td>{{$proc->cantidad}}</td>
			          	</tr>
		          @endforeach
			          	<tr>
			          		<td style="color:white">.</td>
			          	</tr>
			          	<tr>
			          		<td style="color:white">.</td>
			          	</tr>
		        @else
		        	@foreach($detalles as $proc)
			        	<tr>
			            	<td>{{$proc->medicamento}}</td>
			          	</tr>
			          	<tr>
			          		<td>{{$proc->dosis}}</td>
			          	</tr>
			          	<tr>
			          		<td>{{$proc->cantidad}}</td>
			          	</tr>
			          	<tr>
			          		<td style="color:white">.</td>
			          	</tr>
			          	<tr>
			          		<td style="color:white">.</td>
			          	</tr>
			          	<tr>
			          		<td style="color:white">.</td>
			          	</tr>
			          	<tr>
			          		<td style="color:white">.</td>
			          	</tr>
			          	<tr>
			          		<td style="color:white">.</td>
			          	</tr>
		          	@endforeach
		        @endif
		    @else
		    	<tr>
	          		<td style="color:white">.</td>
	          	</tr>
	          	<tr>
	          		<td style="color:white">.</td>
	          	</tr>
	          	<tr>
	          		<td style="color:white">.</td>
	          	</tr>
	          	<tr>
	          		<td style="color:white">.</td>
	          	</tr>
	          	<tr>
	          		<td style="color:white">.</td>
	          	</tr>
	          	<tr>
	          		<td style="color:white">.</td>
	          	</tr>
	          	<tr>
	          		<td style="color:white">.</td>
	          	</tr>
	          	<tr>
	          		<td style="color:white">.</td>
	          	</tr>
		    @endif
	    </table>    
	 </td>
	 </tr>
	</table>
</div>
<br />
<footer>
	<div>
		<table style="border-radius: 5px;border: 2px solid #00b3f2;padding: 5px; width: 100%;height:50px; position: absolute; bottom: 92%;">
			<tr>
				<td align="center" style="font-weight: bold;font-size: 10px">Dra. Kimberly Johanna Amaya Jimenez</td>
			</tr>
			<tr>
				<td align="center" style="font-size: 10px">J.V.P.O 5028</td>
			</tr>
			<tr>
				<td align="center" style="font-size: 10px">Horarios de Lunes a Viernes de 2:00p.m a 6:00 p.m Sabado 8:00 a.m 3:00 p.m
				</td>
			</tr>
			<tr>
				<td align="center" style="font-size: 10px">y mañanas de lunes a viernes</td>
			</tr>
			<tr>
				<td align="center" style="font-size: 10px">TELEFONO 6420-8735 Domingo solo por cita</td>
			</tr>
		</table>
	</div>
</footer>

</body>
</html>