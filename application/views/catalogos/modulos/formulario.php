<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
        <?php echo $link_back; ?>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
            <div class="control-group">
                <label class="control-label hidden-phone">Calle</label>
                <div class="controls">
                    <input type="text" disabled value="<?php echo (isset($calle) ? $calle->nombre : ''); ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="numero">Número</label>
                <div class="controls">
                    <input type="text" id="numero" name="numero" class="required" value="<?php echo (isset($datos->numero) ? $datos->numero : ''); ?>" placeholder="Número">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="frente">Frente</label>
                <div class="controls">
                    <input type="text" id="frente" name="frente" class="required number" value="<?php echo (isset($datos->frente) ? $datos->frente : ''); ?>" placeholder="Frente en m">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="fondo">Fondo</label>
                <div class="controls">
                    <input type="text" id="fondo" name="fondo" class="required number" value="<?php echo (isset($datos->fondo) ? $datos->fondo : ''); ?>" placeholder="Fondo en m">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="precio">Precio <small>(sin IVA)</small></label>
                <div class="controls">
                    <input type="text" id="precio" name="precio" class="required number" value="<?php echo (isset($datos->precio) ? $datos->precio : $calle->precio_base); ?>" placeholder="Precio">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="categoria">Categoría</label>
                <div class="controls">
                    <select id="categoria" name="categoria">
                        <option value="local" <?php echo (isset($datos) && $datos->categoria == 'local' ? 'selected' : ''); ?>>Local</option>
                        <option value="metro" <?php echo (isset($datos) && $datos->categoria == 'metro' ? 'selected' : ''); ?>>Metro</option>
                        <option value="modulo" <?php echo (isset($datos) && $datos->categoria == 'modulo' ? 'selected' : ''); ?>>Módulo</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="tipo">Tipo</label>
                <div class="controls">
                    <select id="tipo" name="tipo">
                        <option value="intermedio" <?php echo (isset($datos) && $datos->tipo == 'intermedio' ? 'selected' : ''); ?>>Intermedio</option>
                        <option value="esquina" <?php echo (isset($datos) && $datos->tipo == 'esquina' ? 'selected' : ''); ?>>Esquina</option>
                        <option value="otro" <?php echo (isset($datos) && $datos->tipo == 'otro' ? 'selected' : ''); ?>>Otro</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="descripcion">Descripción</label>
                <div class="controls">
                    <input type="text" id="descripcion" name="descripcion" value="<?php echo (isset($datos->descripcion) ? $datos->descripcion : ''); ?>" placeholder="Descripción">
                </div>
            </div>
            <!-- <div class="control-group">
                <label class="control-label hidden-phone" for="coordenadas">Coordenadas</label>
                <div class="controls">
                    <input type="text" id="coordenadas" name="coordenadas" value="<?php echo (isset($datos->coordenadas) ? $datos->coordenadas : ''); ?>" placeholder="Coordenadas">
                </div>
            </div> -->
            <div class="control-group">
                <label class="control-labe1" for="imagen_fraccionamiento">Imagen fraccionamiento</label>
                <div class="row">
                    <div class="span11 text-right">
                        <label for="borrar">
                            <input type="button" class="btn btn-danger" id="borrar" value="Reiniciar dibujo" />
                        </label>
                    </div>
                </div>
                <div class="controls span11" style="overflow: auto; height: 700px;">
                    <img id="imagen" style="display: none;" src="<?php echo $plano; ?>" />
                    <canvas id="myCanvas"></canvas>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input type='hidden' id="coordenadas" name="coordenadas" />
                    <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>     
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?php echo $mensaje ?>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    
    $('#numero').focus();
    $('#borrar').click(borrar);

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
    imagen.onload = function() {
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
        if (c == null) {
            return;
        }
        
        c = c.coordenadas;
        var j = json_inicio;
        for (i in c) {
            x.push(c[i].x);
            y.push(c[i].y);
            j += "{ 'x' : '" + c[i].x + "' , 'y' : '" + c[i].y + "' },";
        }
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
        context.globalAlpha = 0.5;
        context.strokeStyle = "#000";
        context.lineWidth = 2;
        context.fillStyle = "#00D2FF";
        context.stroke();
        context.fill();
    }

    canvas.addEventListener('mousemove', function(evt) {
        var mousePos = getMousePos(canvas, evt);
        var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;
    }, false);

    canvas.addEventListener("click", function(evt){
        var mousePos = getMousePos(canvas, evt);
        var j = p.val();
        if(j.length > 0)
            j = j + ',';
        j = j + "{ 'x' : '" + mousePos.x + "' , 'y' : '" + mousePos.y + "' }";
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