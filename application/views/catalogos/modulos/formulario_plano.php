<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
        <?php echo $link_back; ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-condensed">
            <tr class="info">
                <td><strong>Calle</strong></td>
                <td><strong>Módulo</strong></td>
                <td><strong>Categoría</strong></td>
                <td><strong>Tipo</strong></td>
            </tr>
            <tr>
                <td><?php echo $calle->nombre; ?></td>
                <td><?php echo $datos->numero; ?></td>
                <td><?php echo ucfirst($datos->categoria); ?></td>
                <td><?php echo ucfirst($datos->tipo); ?></td>
            </tr>
        </table>
    </div>
<div class="row-fluid">
    <div class="span12" id="plano" style="overflow: auto;">
        <img id="imagen" style="display: none;" src="<?php echo $plano; ?>" />
        <canvas id="myCanvas"></canvas>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <br>
        <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
            <div class="span2">
                <input type='hidden' id="coordenadas" name="coordenadas" />
                <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
            </div>
            <div class="offset8 span2">
                <button class="btn btn-danger" id="borrar">Borrar dibujo</button>
            </div>
        </form>     
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php echo $mensaje ?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    
    $('#numero').focus();
    $('#borrar').click(function(event){
        event.preventDefault();
        borrar();
    });

    function writeMessage(canvas, message) {
        var context = canvas.getContext('2d');
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.font = '18pt Calibri';
        context.fillStyle = 'black';
        context.fillText(message, 10, 25);
    }
    
    function getMousePos(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
            x: evt.clientX - rect.left,
            y: evt.clientY - rect.top
        };
    }
    
    var canvas = document.getElementById('myCanvas');
    var context = canvas.getContext('2d');
    var imagen = document.getElementById('imagen');
    var x = [];
    var y = [];
    var p = $('#coordenadas');
    var json_inicio = '';
    p.val(json_inicio);
    
    // coordenadas
    <?php 
    $coordenadas = 'null';
    if(!empty($datos) && $datos->coordenadas != '' && $datos->coordenadas != 'coordenadas :  ]}')
        $coordenadas = '{'.$datos->coordenadas.'}';
    ?>
    
    var ancho;
    var alto;
    var altoBody = window.innerHeight;
    var plano = document.getElementById('plano');
    
    plano.style.height = altoBody - 320 + "px";
    
    window.onresize = function(){
        altoBody = window.innerHeight;
        plano.style.height = altoBody - 320 + "px";
        dibuja_coord();
    };
    
    imagen.onload = function() {
        imagen.width = imagen.width * 3;
        imagen.height = imagen.height * 3;
        ancho = imagen.width;
        alto = imagen.height;

        canvas.width = ancho;
        canvas.height = alto;
        context.drawImage(imagen, 0, 0, ancho, alto);
        
        dibuja_coord();
    };

    function borrar(){
        context.clearRect(0, 0, ancho, alto);
        context.globalAlpha = 1;
        x = [];
        y = [];
        context.drawImage(imagen, 0, 0, ancho, alto);
        p.val(json_inicio);
    }
    
    function borrar_dibujo(){
        context.clearRect(0, 0, ancho, alto);
        context.globalAlpha = 1;
        context.drawImage(imagen, 0, 0, ancho, alto);
    }
    
    function dibuja_coord() {
        var c = <?php echo $coordenadas; ?>;
        var xProm = 0;
        var yProm = 0;

        if (c === null) {
            // Si no hay polígono se centra el plano
            plano.scrollTop = (plano.scrollHeight - plano.clientHeight) / 2;
            plano.scrollLeft = (plano.scrollWidth - plano.clientWidth) / 2;
            return;
        }
        
        c = c.coordenadas;
        var j = json_inicio;
        var count = 0;
        for (i in c) {
            x.push(c[i].x * 3);
            y.push(c[i].y * 3);
            j += "{ 'x' : '" + c[i].x + "' , 'y' : '" + c[i].y + "' },";
            
            // Sumatoria de las coordenadas x y y.
            xProm = xProm + Number(c[i].x) * 3;
            yProm = yProm + Number(c[i].y) * 3;
            count++; // Cantidad de puntos
        }
        
        // Centra el plano en el polígono del módulo
        xProm = xProm / count;  // Promedio coordenada x (centro)
        yProm = yProm / count;  // Promedio coordenada y (centro)
        plano.scrollTop = yProm - plano.clientHeight / 2;  // Scroll al centro del polígono en y
        plano.scrollLeft = xProm - plano.clientWidth / 2;  // Scroll al centro del polígono en x
        
        p.val(j);
        dibuja();
    }

    function dibuja(){
        context.beginPath();
        var length = x.length;
        for(var i = 0; i < length; i++){
            if(i == 0)
                context.moveTo(x[i],y[i]);
            else
                context.lineTo(x[i],y[i]);
        }
        
        context.globalAlpha = 1;
        context.strokeStyle = "#000";
        context.lineWidth = 4;
        //context.fillStyle = "#00D2FF";
        context.fillStyle = "yellow";
        context.stroke();
        context.fill();
    }

    canvas.addEventListener('mousemove', function(evt) {
        var mousePos = getMousePos(canvas, evt);
        var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;
    }, false);

    canvas.addEventListener("click", function(evt){
        var mousePos = getMousePos(canvas, evt);
        var posXReal = mousePos.x / 3;
        var posYReal = mousePos.y / 3;
        var j = p.val();
        if(j.length > 0)
            j = j + ',';
        j = j + "{ 'x' : '" + posXReal + "' , 'y' : '" + posYReal + "' }";
        p.val(j);
        x.push(mousePos.x);
        y.push(mousePos.y);
        // Borra el poligono antes de dibujar uno nuevo
        borrar_dibujo();
        dibuja();
    
    }, false);

    //dibuja_coord();
});
</script>