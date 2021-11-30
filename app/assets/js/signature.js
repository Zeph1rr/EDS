var canvas, tool, context;

if(window.addEventListener) {

    function imgUpdate() {
        document.getElementById('canvasData').value = canvas.toDataURL('image/png');
    }

    function init() {
        canvas = document.getElementById('paint');
        if(!canvas) {
            alert('Error');
        }
        //console.log(canvas);
        //CanvasRenderingContext2D
        if(!canvas.getContext) {
            alert('Error');
        }
        context = canvas.getContext('2d');
        context.strokeStyle = '#000000';
        context.lineJoin = 'round';
        context.lineWidth = 4;

        tool = new tool_pencil();

        canvas.addEventListener('mousedown',func_canvas,false);
        canvas.addEventListener('mousemove',func_canvas,false);
        canvas.addEventListener('mouseup',func_canvas,false);

    }

    function func_canvas(event) {
        if(event.layerX || event.layerX == 0) {
            event._x = event.layerX;
            event._y = event.layerY;
        }
        else if(event.offsetX || event.offsetX == 0) {
            event._x = event.offsetX;
            event._y = event.offsetY;
        }
        var foo = tool[event.type];
        if(foo) {
            foo(event);
        }
    }

    function tool_pencil() {
        var tool = this;
        tool.started = false;

        tool.mousedown = function (event) {
            context.beginPath();
            context.moveTo(event._x, event._y);
            tool.started = true;
        }

        tool.mousemove = function (event) {

            if(tool.started) {
                context.lineTo(event._x, event._y);
                context.stroke();
            }
        }
        tool.mouseup = function (event) {
            if(tool.started) {
                //this.mousemove(event);
                tool.started = false;
                imgUpdate();
            }
        }
    }

    window.addEventListener('load',function() {

        document.getElementById('clear').addEventListener('click',function() {
            context.clearRect(0,0,canvas.width, canvas.height);
        },false);

        init();

    },false);

}