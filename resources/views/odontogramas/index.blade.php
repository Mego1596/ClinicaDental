<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<br>
	<br>
	<br>
	<div>
		<div align="center">
			<table width="100%">
				<tr>
					<th>Frontal</th>
					<th>Arriba</th>
					<th>Abajo</th>
					<th>Izquierda</th>
					<th>Derecha</th>
					<th>Cubierto</th>
				</tr>
				<tr>
					<td align="center"><button style="width: 80px;height: 70px" id="frontal_1"><img src="{{asset('img/cuadrado.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="arriba_1"><img src="{{asset('img/trapecio_arriba.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="abajo_1"><img src="{{asset('img/trapecio_abajo.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="izquierda_1"><img src="{{asset('img/trapecio_izquierda.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="derecha_1"><img src="{{asset('img/trapecio_derecha.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="todo_1"><img src="{{asset('img/cubierto.png')}}"></button></td>
				</tr>
				<tr>
					<td align="center"><button style="width: 80px;height: 70px" id="frontal_2"><img src="{{asset('img/cuadrado_2.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="arriba_2"><img src="{{asset('img/trapecio_arriba_2.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="abajo_2"><img src="{{asset('img/trapecio_abajo_2.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="izquierda_2"><img src="{{asset('img/trapecio_izquierda_2.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="derecha_2"><img src="{{asset('img/trapecio_derecha_2.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="todo_2"><img src="{{asset('img/cubierto_2.png')}}"></button></td>
				</tr>
				<tr>
					<td align="center"><button style="width: 80px;height: 70px" id="no_diente"><img src="{{asset('img/no_diente.png')}}" width="60px" height="60px"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="puente"><img src="{{asset('img/puente.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="texto"><img src="{{asset('img/texto.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="undo"><img src="{{asset('img/borrador.png')}}"></button></td>
					<td align="center"><button style="width: 80px;height: 70px" id="save"><img src="{{asset('img/save.png')}}"></button></td>
				</tr>
			</table>
		</div>
		<div align="center">
			<h1 id="mensaje"></h1>
			<canvas id="canvas_field" width="1200" height="600" style="border:solid;"></canvas>
		</div>
		<br>
		<br>
	</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.5.0/fabric.min.js"></script>
<script type="text/javascript">
	/*COLOR ROJO TRANSPARENTE #FF000080*/
	/*COLOR AZUL TRANSPARENTE #1745FC80*/
	
	var canvas = this.__canvas = new fabric.Canvas('canvas_field');
	var frontal_1 = document.querySelector('#frontal_1')
	var frontal_2 = document.querySelector('#frontal_2')
	var arriba_1 = document.querySelector('#arriba_1')
	var arriba_2 = document.querySelector('#arriba_2')
	var izquierda_1 = document.querySelector('#izquierda_1')
	var izquierda_2 = document.querySelector('#izquierda_2')
	var derecha_1 = document.querySelector('#derecha_1')
	var derecha_2 = document.querySelector('#derecha_2')
	var abajo_1 = document.querySelector('#abajo_1')
	var abajo_2 = document.querySelector('#abajo_2')
	var todo_1 = document.querySelector('#todo_1')
	var todo_2 = document.querySelector('#todo_2')
	var undo = document.querySelector('#undo')
	var no_diente = document.querySelector('#no_diente')
	var puenta = document.querySelector('#puente')
	var mensaje = document.querySelector('#mensaje')
	var texto = document.querySelector('#texto')
	var guardar = document.querySelector('#save')

	canvas.on('mouse:up', function(e){ canvas.__eventListeners["mouse:down"]=[]; });

	function ubicacion(e,figura){

		//identifica el cuadrante
		var cuadrante, top=0, left=0

		rectax_13  = 28  <= e.pointer.x && e.pointer.x <= 580
		rectay_12  = 62  <= e.pointer.y && e.pointer.y <= 131
		rectayn_12 = 370 <= e.pointer.y && e.pointer.y <= 438

		rectax_24  = 613 <= e.pointer.x && e.pointer.x <= 1165
		rectay_34  = 161 <= e.pointer.y && e.pointer.y <= 228
		rectayn_34 = 468 <= e.pointer.y && e.pointer.y <= 535
		
		/*solo derecha y frontal son diferentes en el primer elemento, los demás son iguales
			se van a recorrer las piezas del centro hacia afuera dependiendo del cuadrante
		*/

		if (rectax_13 && rectay_12) cuadrante = 'C1'

		if (rectax_24 && rectay_12) cuadrante = 'C2'

		if (rectax_13 && rectay_34) cuadrante = 'C3'

		if (rectax_24 && rectay_34) cuadrante = 'C4'

		if (rectax_13 && rectayn_12) cuadrante = 'CN1'

		if (rectax_24 && rectayn_12) cuadrante = 'CN2'

		if (rectax_13 && rectayn_34) cuadrante = 'CN3'

		if (rectax_24 && rectayn_34) cuadrante = 'CN4'
		
		if(cuadrante == 'C1' || cuadrante == 'C2'){
			if(figura =='frontal'){
				top = 83
			}else if (figura == 'arriba' || figura == 'cubierto' ){
				top = 66
			}else if(figura == 'izquierda' || figura == 'derecha'){
				top = 68
			}else if(figura == 'abajo'){
				top = 114
			}
		}

		if(cuadrante == 'C3' || cuadrante == 'C4'){
			if(figura =='frontal'){
				top = 181
			}else if (figura == 'arriba' || figura == 'cubierto' ){
				top = 165
			}else if(figura == 'izquierda' || figura == 'derecha'){
				top = 167
			}else if(figura == 'abajo'){
				top = 213
			}
		}

		if(cuadrante == 'CN1' || cuadrante == 'CN2'){
			if(figura =='frontal'){
				top = 393
			}else if (figura == 'arriba' || figura == 'cubierto' ){
				top = 376
			}else if(figura == 'izquierda' || figura == 'derecha'){
				top = 379
			}else if(figura == 'abajo'){
				top = 424
			}
		}

		if(cuadrante == 'CN3' || cuadrante == 'CN4'){
			if(figura =='frontal'){
				top = 494
			}else if (figura == 'arriba' || figura == 'cubierto' ){
				top = 475
			}else if(figura == 'izquierda' || figura == 'derecha'){
				top = 478
			}else if(figura == 'abajo'){
				top = 524
			}
		}

		if (cuadrante == 'C1' || cuadrante == 'C3'){

			if(figura == 'frontal'){
				left = 537
			}else if (figura == 'derecha'){
				left = 565
			}else{
				left = 521
			}
			z = 580
			for(var i = 0; i < 8; i++){
				if( (z-62) <= e.pointer.x && e.pointer.x <= z){
					break
				}else{
					z -= 70
				}
			}
			left = left - i*70
		}

		if (cuadrante == 'C2' || cuadrante == 'C4'){

			if(figura == 'frontal'){
				left = 633
			}else if (figura == 'derecha'){
				left = 661
			}else{
				left = 617
			}

			z = 613
		    for(var i=0; i< 8;i++){
				if(z<= e.pointer.x && e.pointer.x <= z+62){
					break
				}else{
					z+= 70 
				}
			}

			left = left+(i*70)
		}

		if (cuadrante == 'CN1' || cuadrante == 'CN3'){

			if(figura == 'frontal'){
				left = 537
			}else if (figura == 'derecha'){
				left = 565
			}else{
				left = 521
			}
			z = 580
			for(var i = 0; i < 5; i++){
				if( (z-62) <= e.pointer.x && e.pointer.x <= z){
					break
				}else{
					z -= 70
				}
			}
			left = left - i*70
		}

		if (cuadrante == 'CN2' || cuadrante == 'CN4'){

			if(figura == 'frontal'){
				left = 633
			}else if (figura == 'derecha'){
				left = 661
			}else{
				left = 617
			}

			z = 613
		    for(var i=0; i< 5;i++){
				if(z<= e.pointer.x && e.pointer.x <= z+62){
					break
				}else{
					z+= 70 
				}
			}

			left = left+(i*70)
		}
		return {
			top: top,
			left: left
		}
	}
	function remove() {
		var object = canvas.getActiveObject();
		canvas.remove(object);
		canvas.discardActiveObject();
		canvas.renderAll();
	}
	function cuadrado(color,cubierto = 1){
		if(cubierto != 1){
			rect = new fabric.Rect({
				width: 26,
			    height: 28,
			    top: 0,
			    left: 0,
			    fill: color,
			    hasControls: false,
			    hasBorders: true
			});
		}else{
			rect = new fabric.Rect({
			    width: 59,
			    height: 62,
			    top: 0,
			    left: 0,
			    fill: color,
			    hasControls: false,
			    hasBorders: true
			});
		}

		return rect;
	}
	function poligono_horizontal(color,arriba = 1){
		if(arriba == 1){
			var startPoints = [
			    {x: 55,  y:   0},
			    {x: 42,  y: -14},
			    {x: 98,  y: -14},
			    {x: 85,  y:   0}
			];
		}else{
			var startPoints = [
			    {x: 55,  y:  0},
			    {x: 42,  y: 14},
			    {x: 98,  y: 14},
			    {x: 85,  y:  0}
			];
		}
		
		let polygon = new fabric.Polygon(startPoints, {
		    top: 0,
		    left: 0,
		    fill: color,
		    selectable: true,
		    hasControls: false,
		    hasBorders: true
		});
		return polygon;
	}
	function poligono_vertical(color,izquierda = 1){
		if(izquierda == 1){
			var startPoints = [
			    {x:   0, y:  55},
			    {x: -13, y:  42},
			    {x: -13, y: 100},
			    {x:   0, y:  85}
			];
		}else{
			var startPoints = [
			    {x:  0, y:  55},
			    {x: 13, y:  42},
			    {x: 13, y: 100},
			    {x:  0, y:  85}
			];
		}
		let polygon = new fabric.Polygon(startPoints, {
		    top: 0,
		    left: 0,
		    fill: color,
		    selectable: true,
		    hasControls: false,
		    hasBorders: true
		});
		return polygon
	}

	
	function cuadro_texto(){
		return textbox = new fabric.Textbox('Digite el texto', {
		  left: 540,
		  top: 300,
		  width: 150,
		  fontSize: 20
		});
	}
	undo.addEventListener('click', remove);
	no_diente.addEventListener('click', function(){
		fabric.Image.fromURL('{{asset("img/no_diente.png")}}', function(img) {
		    var oImg = img.set({top: 0,left: 0,hasControls:false}).scale(0.15);
		    canvas.add(oImg);
		});
	})
	texto.addEventListener('click',function(){
			textbox = cuadro_texto();
			textbox.setControlsVisibility({
		    mt: true,
		    mb: false,
		    ml: true,
		    mr: false,
		    tr: false,
		    tl: false,
		    br: true,
		    bl: false
		});
		  	canvas.add(textbox)
	})
	puente.addEventListener('click',function(){
		let line = new fabric.Line([250, 0, 0, 0], {
	        left: 100,
	        top: 100,
	        stroke: 'black',
	        strokeWidth: 10
	    })
	    line.setControlsVisibility({
		    mt: true,
		    mb: false,
		    ml: true,
		    mr: false,
		    tr: false,
		    tl: false,
		    br: false,
		    bl: false
		});
		canvas.add(line);
	})
	frontal_1.addEventListener('click', function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
				rect = cuadrado('#FF000080',0);
		  		coords = ubicacion(e,'frontal')
		  		rect.top = coords.top
		  		rect.left = coords.left
		  		canvas.add(rect)
		  		mensaje.innerHTML = ''
		});
	});
	frontal_2.addEventListener('click', function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
				rect = cuadrado('#1745FC80',0);
		  		coords = ubicacion(e,'frontal')
			  	rect.top = coords.top
			  	rect.left = coords.left
				canvas.add(rect)
				mensaje.innerHTML = ''
		});
	});
	arriba_1.addEventListener('click',function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
			polygon = poligono_horizontal('#FF000080')
	  		coords = ubicacion(e,'arriba')
	  		polygon.top = coords.top
	  		polygon.left = coords.left
	  		canvas.add(polygon)
	  		mensaje.innerHTML = ''
		});
	})
	arriba_2.addEventListener('click',function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
			polygon = poligono_horizontal('#1745FC80')
	  		coords = ubicacion(e,'arriba')
	  		polygon.top = coords.top
	  		polygon.left = coords.left
	  		canvas.add(polygon)
	  		mensaje.innerHTML = ''
		});
	})
	abajo_1.addEventListener('click',function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
			polygon = poligono_horizontal('#FF000080',0)
	  		coords = ubicacion(e,'abajo')
	  		polygon.top = coords.top
	  		polygon.left = coords.left
	  		canvas.add(polygon)
	  		mensaje.innerHTML = ''
		});
	})
	abajo_2.addEventListener('click',function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
			polygon = poligono_horizontal('#1745FC80',0)
	  		coords = ubicacion(e,'abajo')
	  		polygon.top = coords.top
	  		polygon.left = coords.left
	  		canvas.add(polygon)
	  		mensaje.innerHTML = ''
		});
	})
	izquierda_1.addEventListener('click',function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
			polygon = poligono_vertical('#FF000080')
	  		coords = ubicacion(e,'izquierda')
	  		polygon.top = coords.top
	  		polygon.left = coords.left
	  		canvas.add(polygon)
	  		mensaje.innerHTML = ''
		});
	})
	izquierda_2.addEventListener('click',function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
		    polygon = poligono_vertical('#1745FC80')
		  	coords = ubicacion(e,'izquierda')
		  	polygon.top = coords.top
		  	polygon.left = coords.left
		  	canvas.add(polygon)
		  	mensaje.innerHTML = ''
		});
	})
	derecha_1.addEventListener('click',function(){	
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
		    polygon = poligono_vertical('#FF000080',0)
		  	coords = ubicacion(e,'derecha')
		  	polygon.top = coords.top
		  	polygon.left = coords.left
		  	canvas.add(polygon)
		  	mensaje.innerHTML = ''
		});
	})
	derecha_2.addEventListener('click',function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
		    polygon = poligono_vertical('#1745FC80',0)
		  	coords = ubicacion(e,'derecha')
		  	polygon.top = coords.top
		  	polygon.left = coords.left
		  	canvas.add(polygon)
		  	mensaje.innerHTML = ''
		});
	})
	todo_1.addEventListener('click',function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
			rect = cuadrado('#FF000080');
	  		coords = ubicacion(e,'cubierto')
	  		rect.top = coords.top
	  		rect.left = coords.left
	  		canvas.add(rect)
	  		mensaje.innerHTML = ''
		});
	})
	todo_2.addEventListener('click',function(){
		mensaje.innerHTML ='Presione la pieza'
		canvas.on('mouse:down', function(e){
			rect = cuadrado('#1745FC80');
	  		coords = ubicacion(e,'cubierto')
	  		rect.top = coords.top
	  		rect.left = coords.left
	  		canvas.add(rect)
	  		mensaje.innerHTML = ''
		});
	})
	fabric.Image.fromURL("{{asset('img/odontograma.png')}}", function(img) {
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
            scaleX: canvas.width / img.width,
    	    scaleY: canvas.height / img.height
        });
    });

    guardar.addEventListener('click',function(){
		    	
    })

</script>
</html>
