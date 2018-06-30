function Paint(context, options) {
    if (context !== undefined && context !== null) {
        this.context = context;
    }

    if (options !== undefined && options !== null) {
        this.options = options;
    }

    return this;
}

Paint.prototype = {
    context: undefined,
    options: {
        brushColour: "#000000",
        brushWidth: 3
    },
    self: this,
    pos: 0,
    isPainting: false,
    clickX: [],
    clickY: [],
    clickDrag: [],
    addClick: function (x, y, dragging) {
        this.clickX.push(x);
        this.clickY.push(y);
        this.clickDrag.push(dragging);
    },
    clear: function () {
        this.clickX = [];
        this.clickY = [];
        this.clickDrag = [];
        this.pos = 0;
        this.context.clearRect(0, 0, this.context.canvas.width, this.context.canvas.height);
    },
    draw: function () {
        this.context.strokeStyle = this.options.brushColour;
        this.context.lineJoin = "round";
        this.context.lineWidth = this.options.brushWidth;     
        
        while (this.pos < this.clickX.length) {
            this.context.beginPath();
            if (this.clickDrag[this.pos] && this.pos) {
                this.context.moveTo(this.clickX[this.pos - 1], this.clickY[this.pos - 1]);
            } else {
                this.context.moveTo(this.clickX[this.pos] - 1, this.clickY[this.pos]);
            }

            this.context.lineTo(this.clickX[this.pos], this.clickY[this.pos]);
            this.context.closePath();
            this.context.stroke();
            this.pos++;
        }
    },
    drawImage: function (imageUrl) {
		var imageObj = new Image();
		var context = this.context;
		imageObj.onload = function() {
			context.drawImage(imageObj, 0, 0, 1024, 768);
		};
		imageObj.src = imageUrl;
	},
    stop: function () {
        this.isPainting = false;
    }
}
