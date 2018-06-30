$( function() {
	var canvas = $("#myCanvas");
	var paint = new Paint(canvas[0].getContext("2d"));

	function getMousePosition(event, canvas) {
		var x, y;

		if (event.offsetX) {
			x = event.offsetX;
			y = event.offsetY;
		} else {
			x = event.pageX - canvas.offsetLeft;
			y = event.pageY - canvas.offsetTop;
		}

		return {
			x: x,
			y: y
		};
	}

	canvas.mousedown(function(e) {
		var pos = getMousePosition(e, this);
		paint.isPainting = true;
		paint.addClick(pos.x, pos.y, false);
		paint.draw();
	});

	canvas.mousemove(function(e) {
		if (paint.isPainting) {
			var pos = getMousePosition(e, this);
			paint.addClick(pos.x, pos.y, true);
			paint.draw();
		}
	});

	canvas.mouseup(function(e) {
		paint.stop();
	});

	canvas.mouseleave(function(e) {
		paint.stop();
	});

	$("#clearButton").click(function() {
		paint.clear();
	});
	
	$("#colorPalette a").click(function() {
		$("#colorPalette a").removeClass("active");
		$(this).addClass("active");
		paint.options.brushColour = "#"+this.name;
	});
	
	$("#newPaintModal").modal({
		backdrop: 'static',
		keyboard: false
	});
	
	$("#clearCanvasBtn").click(function() {
		paint.clear();
	});
	
	$("#saveCanvasBtn").click(function() {
		var dataURL = canvas[0].toDataURL().replace('data:image/png', 'data:application/octet-stream');
		window.open(dataURL);
	});
	
	$("#blankCanvas").click(function() {
		paint.clear();
		$("#newPaintModal").modal("hide");
	});
	
	$("#batmanCanvas").click(function() {
		paint.clear();
		paint.drawImage("img/batman.gif");
		$("#newPaintModal").modal("hide");
	});
	
	$("#spidermanCanvas").click(function() {
		paint.clear();
		paint.drawImage("img/spiderman.gif");
		$("#newPaintModal").modal("hide");
	});
});
