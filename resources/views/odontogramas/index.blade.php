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
				<td align="center"><button id="frontal_1"><img src="{{asset('img/cuadrado.png')}}"></button></td>
				<td align="center"><button id="arriba_1"><img src="{{asset('img/trapecio_arriba.png')}}"></button></td>
				<td align="center"><button id="abajo_1"><img src="{{asset('img/trapecio_abajo.png')}}"></button></td>
				<td align="center"><button id="izquierda_1"><img src="{{asset('img/trapecio_izquierda.png')}}"></button></td>
				<td align="center"><button id="derecha_1"><img src="{{asset('img/trapecio_derecha.png')}}"></button></td>
				<td align="center"><button id="todo_1"><img src="{{asset('img/cubierto.png')}}"></button></td>
			</tr>
			<tr>
				<td align="center"><button id="frontal_2"><img src="{{asset('img/cuadrado_2.png')}}"></button></td>
				<td align="center"><button id="arriba_2"><img src="{{asset('img/trapecio_arriba_2.png')}}"></button></td>
				<td align="center"><button id="abajo_2"><img src="{{asset('img/trapecio_abajo_2.png')}}"></button></td>
				<td align="center"><button id="izquierda_2"><img src="{{asset('img/trapecio_izquierda_2.png')}}"></button></td>
				<td align="center"><button id="derecha_2"><img src="{{asset('img/trapecio_derecha_2.png')}}"></button></td>
				<td align="center"><button id="todo_2"><img src="{{asset('img/cubierto_2.png')}}"></button></td>
			</tr>
		</table>
	</div>
	<div align="center">
		<canvas id="canvas_field" width="1200" height="600" style="border:solid;"></canvas>
	</div>
	<br>
	<br>
	
</div>
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
	frontal_1.addEventListener('click', function(){
		var rect = new fabric.Rect({
		    width: 26,
		    height: 28,
		    top: 0,
		    left: 0,
		    fill: '#FF000080',
		    hasControls: false,
		    hasBorders: false
		  });
		canvas.add(rect);
	})

	frontal_2.addEventListener('click',function(){
		var rect = new fabric.Rect({
		    width: 26,
		    height: 28,
		    top: 0,
		    left: 0,
		    fill: '#1745FC80',
		    hasControls: false,
		    hasBorders: false
		  });
		canvas.add(rect);
	})

	arriba_1.addEventListener('click',function(){
		var startPoints = [
		    {x: 55,  y:   0},
		    {x: 42,  y: -14},
		    {x: 98,  y: -14},
		    {x: 85,  y:   0}
		];
		var polygon = new fabric.Polygon(startPoints, {
		    top: 0,
		    left: 0,
		    fill: '#FF000080',
		    selectable: true,
		    hasControls: false,
		    hasBorders: false
		});
		canvas.add(polygon);
	})

	arriba_2.addEventListener('click',function(){
		var startPoints = [
		    {x: 55,  y:   0},
		    {x: 42,  y: -14},
		    {x: 98,  y: -14},
		    {x: 85,  y:   0}
		];
		var polygon = new fabric.Polygon(startPoints, {
		    top: 0,
		    left: 0,
		    fill: '#1745FC80',
		    selectable: true,
		    hasControls: false,
		    hasBorders: false
		});
		canvas.add(polygon);
	})

	izquierda_1.addEventListener('click',function(){
		var startPoints = [
		    {x:   0, y:  55},
		    {x: -13, y:  42},
		    {x: -13, y: 100},
		    {x:   0, y:  85}
		  ];
		var polygon = new fabric.Polygon(startPoints, {
		    top: 0,
		    left: 0,
		    fill: '#FF000080',
		    selectable: true,
		    hasControls: false,
		    hasBorders: false
		});
		canvas.add(polygon);
	})

	izquierda_2.addEventListener('click',function(){
		var startPoints = [
		    {x:   0, y:  55},
		    {x: -13, y:  42},
		    {x: -13, y: 100},
		    {x:   0, y:  85}
		  ];
		var polygon = new fabric.Polygon(startPoints, {
		    top: 0,
		    left: 0,
		    fill: '#1745FC80',
		    selectable: true,
		    hasControls: false,
		    hasBorders: false
		});
		canvas.add(polygon);
	})

	derecha_1.addEventListener('click',function(){
		var startPoints = [
		    {x:  0, y:  55},
		    {x: 13, y:  42},
		    {x: 13, y: 100},
		    {x:  0, y:  85}
		  ];
		var polygon = new fabric.Polygon(startPoints, {
		    left: 0,
		    top: 0,
		    fill: '#FF000080',
		    selectable: true,
		    hasControls: false,
		    hasBorders: false
		});
		canvas.add(polygon);
	})

	derecha_2.addEventListener('click',function(){
		var startPoints = [
		    {x:  0, y:  55},
		    {x: 13, y:  42},
		    {x: 13, y: 100},
		    {x:  0, y:  85}
		  ];
		var polygon = new fabric.Polygon(startPoints, {
		    left: 0,
		    top: 0,
		    fill: '#1745FC80',
		    selectable: true,
		    hasControls: false,
		    hasBorders: false
		});
		canvas.add(polygon);
		})

	abajo_1.addEventListener('click',function(){
		var startPoints = [
		    {x: 55,  y:  0},
		    {x: 42,  y: 14},
		    {x: 98,  y: 14},
		    {x: 85,  y:  0}
		];
		var polygon = new fabric.Polygon(startPoints, {
		    top: 0,
		    left: 0,
		    fill: '#FF000080',
		    selectable: true,
		    hasControls: false,
		    hasBorders: false
		});
		canvas.add(polygon);
	})

	abajo_2.addEventListener('click',function(){
		var startPoints = [
		    {x: 55,  y:  0},
		    {x: 42,  y: 14},
		    {x: 98,  y: 14},
		    {x: 85,  y:  0}
		];
		var polygon = new fabric.Polygon(startPoints, {
		    top: 0,
		    left: 0,
		    fill: '#1745FC80',
		    selectable: true,
		    hasControls: false,
		    hasBorders: false
		});
		canvas.add(polygon);
	})

	todo_1.addEventListener('click',function(){
		var rect2 = new fabric.Rect({
		    width: 59,
		    height: 62,
		    top: 0,
		    left: 0,
		    fill: '#FF000080',
		    hasControls: false,
		    hasBorders: false
		});
		canvas.add(rect2);
	})

	todo_2.addEventListener('click',function(){
		var rect2 = new fabric.Rect({
		    width: 59,
		    height: 62,
		    top: 0,
		    left: 0,
		    fill: '#1745FC80',
		    hasControls: false,
		    hasBorders: false
		 });
		canvas.add(rect2);
	})
	fabric.Image.fromURL("{{asset('img/odontograma.png')}}", function(img) {
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
            scaleX: canvas.width / img.width,
    	    scaleY: canvas.height / img.height
        });
    });
</script>


