
<div class="table-responsive" align="center">
	<canvas id="canvas_field" width="1500" height="600"></canvas>
</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.5.0/fabric.min.js"></script>
	<script type="text/javascript">
		var canvas = this.__canvas = new fabric.Canvas('canvas_field');
		//CARA FRONTAL DEL DIENTE
		var rect = new fabric.Rect({
		    width: 33,
		    height: 29,
		    top: 50,
		    left: 50,
		    fill: 'rgba(255,0,0,0.5)'
		  });
		var rect = new fabric.Rect({
		    width: 33,
		    height: 29,
		    top: 100,
		    left: 100,
		    fill: 'rgba(255,0,0,0.5)'
		  });
		canvas.add(rect).setActiveObject(rect);
		//FIN CARA FRONTAL DEL DIENTE

		//LADO DERECHO DEL DIENTE
		var startPoints = [
		    {x: 0, y: 51},
		    {x: 18, y: 35},
		    {x: 18, y: 100},
		    {x: 0, y: 85}
		  ];
		var polygon = new fabric.Polygon(startPoints, {
		    left: 0,
		    top: 0,
		    fill: 'rgba(255,0,0,0.5)',
		    selectable: true,
		});
		canvas.add(polygon);
		//FIN LADO DERECHO DEL DIENTE
		//LADO IZQUIERDO DEL DIENTE
		var startPoints = [
		    {x: 0, y: 51},
		    {x: -18, y: 35},
		    {x: -18, y: 100},
		    {x: 0, y: 85}
		  ];
		var polygon = new fabric.Polygon(startPoints, {
		    left: 100,
		    top: 100,
		    fill: 'rgba(255,0,0,0.5)',
		    selectable: true,
		});
		canvas.add(polygon);
		//FIN LADO IZQUIERDO DEL DIENTE
		//LADO DE ARRIBA DEL DIENTE
		var startPoints = [
		    {x: 51, y: 0},
		    {x: 35, y:18},
		    {x: 110,y:18},
		    {x: 87, y: 0}
		];
		var polygon = new fabric.Polygon(startPoints, {
		    left: 200,
		    top: 200,
		    fill: 'rgba(255,0,0,0.5)',
		    selectable: true,
		});
		canvas.add(polygon);
		//FIN DEL LADO DE ARRIBA DEL DIENTE

		//LADO DE ABAJO DEL DIENTE
		var startPoints = [
		    {x: 51, y: 0},
		    {x: 35, y:-18},
		    {x: 110,y:-18},
		    {x: 87, y: 0}
		];
		var polygon = new fabric.Polygon(startPoints, {
		    left: 200,
		    top: 200,
		    fill: 'rgba(255,0,0,0.5)',
		    selectable: true,
		});
		canvas.add(polygon);
		//FIN DEL LADO DE ABAJO DEL DIENTE

		fabric.Image.fromURL("{{asset('img/odontograma.png')}}", function(img) {
	        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
	            scaleX: canvas.width / img.width,
	    	    scaleY: canvas.height / img.height
	        });
	    });
	</script>


