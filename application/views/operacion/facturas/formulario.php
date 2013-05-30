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
        <label class="control-label" for="id_recibo[]">Recibo(s)</label>
        <div class="controls" style="height: 75px; overflow-y: auto;">
            <?php
            foreach($recibos as $r){ ?>
                <label class="checkbox">
                    <input type="checkbox" name="id_recibo[]" importe="<?php echo $r->total; ?>" value="<?php echo $r->id; ?>" <?php if(isset($id_recibo) && $id_recibo == $r->id) echo "checked"; ?>> <?php echo $r->numero." - ".$r->cliente; ?>
                </label>
            <?php
            }
            ?>
        </div>
        <div id="mensajes_recibos"></div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="total">Importe</label>
        <div class="controls">
            <input type="hidden" name="total" value="<?php if(!empty($recibo->total)){ echo $recibo->total; } ?>" class="required" />
            <input type="text" id="total" disabled placeholder="Importe" value="<?php if(!empty($recibo->total)){ echo $recibo->total; } ?>" class="required" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="serie">Serie</label>
        <div class="controls">
            <input type="text" name="serie" id="serie" placeholder="Serie" value="<?php if(isset($serie)) echo $serie; ?>"/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="folio">Folio</label>
        <div class="controls">
            <input type="text" name="folio" id="folio" placeholder="Folio" value="<?php if(isset($folio)) echo $folio; ?>" class="required" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="fecha">Fecha</label>
        <div class="controls">
            <input type="text" class="fecha required" name="fecha" id="fecha" placeholder="Fecha" />
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn">Guardar</button>
        </div>
      </div>
    </div>
</div>
<div class="row-fluid">
  <div class="span6 offset3" id="mensajes">
    <?php echo $mensaje ?>
  </div>
</div>

<script>
    var total = Number(0);
    
    $(document).ready(function(){
        var input_total = $('input[name="total"]');
        var input_fake = $('#total');
        
        // Calcula el total de la factura sumando los recibos seleccionados
        function calcula_total(){
            total = 0;
            $('input[type="checkbox"]').each(function(){
                if($(this).is(':checked')){
                    total += Number($(this).attr('importe'));
                }
            });
            if(total > 0){
                input_fake.val(Globalize.format( total, "n" ));
                input_total.val(total);
            }else{
                input_fake.val('');
                input_total.val('');
            }
        }
        
        // Al cargar la página se calcula el total
        calcula_total();
        
        // Cuando se cambia un checkbox se recalcula el total
        $('input[type="checkbox"]').change(function(){
            calcula_total();
        });
        
        // Confirmamos si quiere guardar la factura
        $('form').validate({
            submitHandler: function(form) {
                var confirmar = confirm('¿Guardar factura?');
                if(confirmar)
                    form.submit();
            },
            rules:{
                "id_recibo[]":{
                    required: true
                }
            },
            messages: {
                "id_recibo[]": "Es necesario seleccionar al menos un recibo"
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "id_recibo[]") {
                  $('#mensajes_recibos').html(error);
                  //error.html("form");
                } else {
                  error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass) {
                $(element).fadeOut(function() {
                  $(element).fadeIn();
                });
            }
        });
       
    });
</script>