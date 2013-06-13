<div class="row-fluid">
    <div class="span12">
        <div style="overflow: auto; width: 100%;">
            <!-- Contenedor del canvas generado por Kinetic -->
            <div id="container"></div>
        </div>
    </div>
</div>

<script src="<?php echo asset_url(); ?>js/kinetic.min.js"></script>
<script defer="defer">
    // Kinetic
    var stage = new Kinetic.Stage({
        container: 'container',
        width: 1,
        height: 1
    });
    
    var layer = new Kinetic.Layer();
    var messageLayer = new Kinetic.Layer();
    
    function writeMessage(messageLayer, message) {
        var context = messageLayer.getContext();
        messageLayer.clear();
        context.font = '18pt Calibri';
        context.fillStyle = 'black';
        context.fillText(message, 10, 25);
      }
      
    function dibuja(){
        var c = <?php echo $coordenadas; ?>;
        var coord = null;
        var xy = [];
        var color = '#eee';

        /*if (c == null) {
            return;
        }*/
        $.each(c, function(key, val){
            coord = val.coordenadas;
            
            for (i in coord) {
                xy.push(coord[i].x);
                xy.push(coord[i].y);
            }
            if(val.disponible === '1')
                color = '#eee';
            else
                color = 'red';
            var poly = new Kinetic.Polygon({
                points: xy,
                fill: color,
                stroke: color,
                strokeWidth: 1,
                opacity: 0.4,
                id_calle: val.id_calle,
                calle: val.calle,
                id: val.id,
                numero: val.numero,
                cliente: val.cliente,
                giro: val.giro,
                disponible: val.disponible
              });
            // add the shape to the layer
            layer.add(poly);
            
            xy = [];
        });
        
        var rect = new Kinetic.Rect({
          x: imageObj.width / 2,
          y: imageObj.height - 80,
          width: 20,
          height: 20,
          fill: 'red',
          stroke: 'black',
          strokeWidth: 1
        });

        var nodisponibleText = new Kinetic.Text({
          x: imageObj.width / 2 + 25,
          y: imageObj.height - 75,
          text: 'Vendido',
          fontSize: 15,
          fontFamily: 'Helvetica',
          fill: 'black'
        });

        // add the shape to the layer
        layer.add(nodisponibleText);
        layer.add(rect);
        
        // Tags para información de los módulos
        label = new Kinetic.Label({
            x: 150,
            y: 100, 
            draggable: true
        });

          // add a tag to the label
        label.add(new Kinetic.Tag({
            fill: 'yellow',
            opacity: 0.8,
            stroke: '#333',
            strokeWidth: 1,
            shadowColor: 'black',
            shadowBlur: 10,
            shadowOffset: [5, 5],
            shadowOpacity: 0.5,
            lineJoin: 'round',
            pointerDirection: 'down',
            pointerWidth: 15,
            pointerHeight: 15,
            cornerRadius: 10
        }));

        var info = new Kinetic.Text({
            text: '',
            fontSize: 12,
            lineHeight: 1,
            padding: 5,
            fill: 'black',
            fontFamily: 'Helvetica'
        });
          // add text to the label
        label.add(info);
        
        stage.add(layer);
        
        // Evento cuando se pasa el mouse sobre algún poligono
        var shapes = stage.get('Polygon');
        shapes.on('mouseover', function(){
            var texto = '';
            // Si el módulo está diponible se cambia el cursor a "manita"
            if(this.getAttr('disponible') === '1')
                document.body.style.cursor = 'pointer';
            else
                texto = this.getAttr('giro')+'\n'+this.getAttr('cliente')+'\n';
            texto += this.getAttr('calle')+' #'+this.getAttr('numero');
            info.setText(texto);
            
            // Se obtiene la posición del mouse para posisionar el tag
            var mouseXY = stage.getMousePosition();
            var canvasX = mouseXY.x;
            var canvasY = mouseXY.y;
            
            label.setAttr('x',canvasX);
            label.setAttr('y',canvasY);
            
            this.setOpacity(0.8);
            layer.add(label);
            layer.draw();
        });
        shapes.on('mouseout', function(){
            document.body.style.cursor = 'default';  
            this.setOpacity(0.4);
            label.remove();
            layer.draw();
        });
        
        // Al dar click en un polígono
        shapes.on('click', function(){
            /*if(this.getAttr('disponible') === '1'){
                $('#apartar').removeAttr('disabled').attr('href','<?php echo site_url('ventas/ventas/apartados_add'); ?>'+'/'+this.getAttr('id_fraccionamiento')+'/'+this.getAttr('id_manzana')+'/'+this.getAttr('id_lote'));
            }else{
                $('#apartar').attr('disabled', 'disabled').attr('href','#');
            }
            $('#myModalLabel').html(this.getAttr('modelo'));
            $('#foto1').attr('src',this.getAttr('foto'));
            $('#myModal').modal('show');*/
        });
        //stage.add(messageLayer);
    }

    var imageObj = new Image();
    imageObj.onload = function() {
      var lotificacion = new Kinetic.Image({
        x: 0,
        y: 0,
        image: imageObj,
        width: imageObj.width,
        height: imageObj.height,
      });

      // add the shape to the layer
      layer.add(lotificacion);

      // add the layer to the stage
      stage.setWidth (imageObj.width);
      stage.setHeight (imageObj.height);
      dibuja();
    };
    imageObj.src = '<?php echo $plano; ?>';

</script>