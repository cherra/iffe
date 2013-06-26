<div class="row-fluid">
    <div class="span12">
        <!-- Contenedor del canvas generado por Kinetic -->
            <div id="container" style="width: 100%;"></div>
    </div>
</div>

<script src="<?php echo asset_url(); ?>js/kinetic.min.js"></script>
<script defer="defer">
    // Kinetic
    var stage = new Kinetic.Stage({
        container: 'container',
        width: 1,
        height: 1,
        draggable: true
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
            if(val.disponible !== '1')
            {
                color = 'red';
                var poly = new Kinetic.Polygon({
                    points: xy,
                    fill: color,
                    stroke: color,
                    strokeWidth: 1,
                    opacity: 0.5,
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
            }
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
          text: 'Rentado',
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
            fill: 'lightgray',
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
        var x,y;
        var shapes = stage.get('Polygon');
        shapes.on('mouseover', function(){
            info.setText(this.getAttr('giro')+'\n'+this.getAttr('cliente')+'\n'+this.getAttr('calle')+' #'+this.getAttr('numero'));
            
            var mouseXY = stage.getMousePosition();
            var canvasX = mouseXY.x - stage.getAttr('x');
            var canvasY = mouseXY.y - stage.getAttr('y');
            
            label.setAttr('x',canvasX);
            label.setAttr('y',canvasY);
            //tag.set
            this.setOpacity(0.9);
            layer.add(label);
            layer.draw();
        });
        shapes.on('mouseout', function(){
            this.setOpacity(0.5);
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
        height: imageObj.height
      });

      // add the shape to the layer
      layer.add(lotificacion);

      stage.setWidth ($('#container').width());
      stage.setHeight (imageObj.height);
      dibuja();
    };
    imageObj.src = '<?php echo $plano; ?>';
    
    window.onresize=function(){
        stage.setWidth ($('#container').width());
    };

</script>