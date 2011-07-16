var CANVAS_HEIGHT = 500;
var CANVAS_WIDTH = 500;
var dragging = false;
var currentTool = "pencil"; // Possible tools are "pencil", "eraser", "floodFill", "stamp"
var offsetX; // Distance from canvas to left of screen
var offsetY; // Distance from canvas to top of screen
var oldX = 0; // The mouse's previous x position
var oldY = 0; // The mouse's previous y position
var ctx; // Drawing context
var undoStack = []; // Stack containing imageData of previous states
var prefix = "paint/";
//var prefix = "";

var eraser = new Image();
eraser.src = prefix + "eraserCursor.png";

Event.observe(window, 'load', function() {
	if (!$("canvas").getContext) return;
	
	// Setup canvas
	ctx = $("canvas").getContext("2d");
	
	// Setup listeners
	Event.observe('canvas', 'mousedown', mouseDown);
	Event.observe(document, 'mouseup', mouseUp);
	Event.observe(document, 'mousemove', mouseMove);
	
	// Set global variables
	offsetY = $("canvas").offsetTop;
	offsetX = $("canvas").offsetLeft;
	
	// Setup tools
	var tools = ["pencil", "eraser", "undo"];
	var table = document.createElement("table");
	
	for (var i = 0; i < tools.length; i++) {
		var tool = document.createElement("img");
		tool.id = tools[i];
		if (i < 2) {
			tool.onclick = changeTool;
		}
		else {
			tool.onclick = revertState;
		}
		tool.src = prefix + tools[i] + ".png";
		tool.alt = "";
		tool.title = tools[i].charAt(0).toUpperCase() + tools[i].substring(1);
		$("tools").appendChild(tool);
	}
	
	
	// Setup colors
	var colors = ["0, 0, 0", "80, 80, 80", "160, 160, 160", "255, 255, 255", "255, 0, 0", "255, 128, 128", "255, 165, 0", "255, 210, 128", "255, 255, 0", "255, 255, 128", "0, 128, 0", "64, 128, 64", "0, 0, 255", "128, 128, 255", "75, 0, 130", "103, 65, 130", "237, 0, 237", "237, 119, 237"];
	var table = document.createElement("table");
	for (var i = 0; i < colors.length;) {
		var tr = document.createElement("tr");
		
		var td = document.createElement("td");
		if (i == 0) td.id = "black";
		td.style.backgroundColor = "rgb(" + colors[i++] + ")";
		td.onclick = changeColor;
		tr.appendChild(td);
		
		var td2 = document.createElement("td");
		td2.style.backgroundColor = "rgb(" + colors[i++] + ")";
		td2.onclick = changeColor;
		tr.appendChild(td2);
		
		table.appendChild(tr);
	}
	
	$("colors").appendChild(table);
	
	var currentColor = document.createElement("div");
	currentColor.id = "currentColor";
	$("colors").appendChild(currentColor);
	
	// Set defaults
	ctx.fillStyle = "white";
	//ctx.fillRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
	$("pencil").onclick();
	$("black").onclick();
	undoStack.push(ctx.getImageData(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT));
	
	// Set box mouseovers	
	var hoverBoxes = $$("td, #tools div");
	for (var i = 0; i < hoverBoxes.length; i++) {
		hoverBoxes[i].onmouseover = boxMouseOver;
		hoverBoxes[i].onmouseout = boxMouseOut;
	}
});

function mouseDown(e) {
	dragging = true;
	var currentX = e.pageX - offsetX;
	var currentY = e.pageY - offsetY;
	
	if (currentTool == "pencil") {
		ctx.fillRect(currentX - 1, currentY - 1, 2, 2);
	}
	
	else if (currentTool == "eraser") {
		ctx.beginPath();
		ctx.arc(currentX, currentY, 16, 0, Math.PI * 2, false);
		ctx.fill();
	}
}

function revertState() {
	if (undoStack.length > 1) {
		ctx.putImageData(undoStack[undoStack.length - 2], 0, 0);
		undoStack.pop();
	}
}

function saveImage() {
	var dataURL = $("canvas").toDataURL("image/png");
	
	new Ajax.Request(
		"saveimg.php",
		{
			method: "POST",
			onSuccess: callback,
			parameters: { "dataURL": dataURL, "imgNum": imgNum }
		}
	);
}

function callback(ajax) {
	// Do something after successfully saved image
	ajax.responseText;
}

function mouseUp() {
	if (dragging) {
		dragging = false;
		undoStack.push(ctx.getImageData(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT));
	}
	$("canvasinput").value = $("canvas").toDataURL("image/png");
}

function mouseMove(e) {
	var currentX = e.pageX - offsetX;
	var currentY = e.pageY - offsetY;
	ctx.beginPath();
	ctx.moveTo(oldX, oldY);
	if (dragging) {
		ctx.lineTo(currentX, currentY);
		ctx.stroke();
	}
	oldX = currentX;
	oldY = currentY;
}

function changeColor() {
	if (currentTool == "pencil") {
		ctx.strokeStyle = this.style.backgroundColor;
		ctx.fillStyle = this.style.backgroundColor;
	}
	$("currentColor").style.backgroundColor = this.style.backgroundColor;
	this.style.border = "1px solid " + $("currentColor").style.backgroundColor;
}

function changeTool() {
	currentTool = this.id;
	if (currentTool == "pencil") {
		$("canvas").style.cursor = "url(" + prefix + "pencil.png) 0 88, crosshair";
		ctx.strokeStyle = $("currentColor").style.backgroundColor;
		ctx.fillStyle = $("currentColor").style.backgroundColor;
		ctx.lineWidth = 3;
		ctx.lineCap = "butt";
		ctx.globalCompositeOperation = "source-over";
		
	}
	
	else if (currentTool == "eraser") {
		$("canvas").style.cursor = "url(" + prefix + "eraserCursor.png) 16 16, crosshair";
		ctx.fillStyle = "white";
		ctx.strokeStyle = "white";
		ctx.lineWidth = 32;
		ctx.lineCap = "round";
		ctx.globalCompositeOperation = "destination-out";
		
	}
}

function boxMouseOver() {
	this.style.border = "1px solid " + $("currentColor").style.backgroundColor;
}

function boxMouseOut() {
	this.style.border = "1px solid #6BABCE";
}
