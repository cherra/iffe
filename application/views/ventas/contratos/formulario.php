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
        <div class="controls">
          <input type="hidden" name="id_contrato">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="id_apartado">Apartado</label>
        <div class="controls">
          <select name="id_apartado" id="id_apartado">
              <option value="0">Selecciona un apartado...</option>
              <?php
              foreach($apartados as $a){
              ?>
                <option value="<?php echo $a->id_apartado; ?>" <?php if(!empty($id_apartado)) echo ($id_apartado == $a->id_apartado ? "selected" : ""); ?>><?php echo $a->username.' - '.$a->cliente; ?></option>
              <?php
              }
              ?>
          </select>
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label hidden-phone" for="id_fraccionamiento">Fraccionamiento</label>
        <div class="controls">
          <select name="id_fraccionamiento" id="id_fraccionamiento" required>
              <option value="0">Selecciona un fraccionamiento...</option>
              <?php
              foreach($fraccionamientos as $f){
              ?>
                <option value="<?php echo $f->id_fraccionamiento; ?>" <?php if(!empty($id_fraccionamiento)) echo ($id_fraccionamiento == $f->id_fraccionamiento ? "selected" : ""); ?>><?php echo $f->descripcion; ?></option>
              <?php
              }
              ?>
          </select>
        </div>
      </div>
        
      <div class="control-group">
        <label class="control-label hidden-phone" for="id_manzana">Manzana</label>
        <div class="controls">
          <select name="id_manzana" id="id_manzana" required <?php if(!isset($id_fraccionamiento)) echo "disabled"; ?>>
            <option value="0">Selecciona una manzana...</option>
            <?php foreach ($manzanas as $m){ ?>
                <option value="<?php echo $m->id_manzana; ?>" <?php if(!empty($id_manzana)) echo ($id_manzana == $m->id_manzana ? "selected" : ""); ?>><?php echo $m->descripcion; ?></option>
            <?php
              }
            ?>
          </select>
        </div>
      </div>
        
      <div class="control-group">
        <label class="control-label hidden-phone" for="id_lote">Lote</label>
        <div class="controls">
          <select name="id_lote" id="id_lote" class="required" <?php if(!isset($id_manzana)) echo "disabled"; ?>>
            <option value="">Selecciona un Lote...</option>
            <?php foreach($lotes as $l){ ?>
                <option value="<?php echo $l->id_lote; ?>" <?php if(!empty($id_lote)) echo ($id_lote == $l->id_lote ? "selected" : ""); ?>><?php echo $l->descripcion; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="control-group">
          <label class="control-label hidden-phone">Casa</label>
          <div class="controls">
              <input type="text" disabled value="<?php echo (!empty($casa->descripcion) ? $casa->descripcion : ''); ?>"/>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label hidden-phone">Precio</label>
          <div class="controls">
            <div class="input-prepend">
                <span class="add-on">$</span>
                <input type="text" class="span11" disabled value="<?php echo (!empty($casa->precio) ? number_format($casa->precio,2,'.',',') : ''); ?>"/>
            </div>
          </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="txt_cliente">Cliente</label>
        <div class="controls">
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo (!empty($cliente) ? $cliente->id_cliente : '0'); ?>"/>
            <input type="text" id="txt_cliente" placeholder="Cliente" value="<?php if(!empty($cliente)) echo $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno; ?>" autocomplete="off" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="fecha">Fecha</label>
        <div class="controls">
          <input type="text" class="fecha date" name="fecha" id="fecha" value="<?php echo (isset($contrato->fecha) ? $contrato->fecha : $fecha); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="fecha_vencimiento">Fecha de vencimiento</label>
        <div class="controls">
            <input type="hidden" name="fecha_vencimiento" value="<?php echo (isset($contrato->fecha_vencimiento) ? $contrato->fecha_vencimiento : $fecha_vencimiento); ?>">
            <input class="fecha" disabled type="text" value="<?php echo (isset($contrato->fecha_vencimiento) ? $contrato->fecha_vencimiento : $fecha_vencimiento); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="observaciones">Observaciones</label>
        <div class="controls">
          <textarea name="observaciones" 
                    id="observaciones" 
                    placeholder="Observaciones" 
                    rows="5"><?php echo $variable = (isset($contrato->observaciones) ? $contrato->observaciones : ''); ?></textarea>
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
  <div class="span6 offset3">
    <?php echo $mensaje ?>
  </div>
</div>

<script>
$(document).ready(function(){
    var url = "<?php echo site_url(); ?>/ventas/ventas/contratos_add";
    $('#id_apartado').change(function(){
        if($(this).val() > 0)
           $(location).attr('href',url+'/'+$(this).val()+'/'+$('#id_cliente').val()+'/'+$('#fecha').val());
    });
    $('#id_fraccionamiento').change(function(){
        if($(this).val() > 0)
           $(location).attr('href',url+'/'+$('#id_apartado').val()+'/'+$('#id_cliente').val()+'/'+$('#fecha').val()+'/'+$(this).val());
    });
    
    $('#id_manzana').change(function(){
        if($(this).val() > 0)
           $(location).attr('href',url+'/'+$('#id_apartado').val()+'/'+$('#id_cliente').val()+'/'+$('#fecha').val()+'/'+$('#id_fraccionamiento').val()+'/'+$(this).val());
    });
    
    $('#id_lote').change(function(){
        if($(this).val() > 0)
           $(location).attr('href',url+'/'+$('#id_apartado').val()+'/'+$('#id_cliente').val()+'/'+$('#fecha').val()+'/'+$('#id_fraccionamiento').val()+'/'+$('#id_manzana').val()+'/'+$(this).val());
    });
    
    $('#fecha').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        onSelect: function(dateText){
            $(location).attr('href',url+'/'+$('#id_apartado').val()+'/'+$('#id_cliente').val()+'/'+dateText+'/'+$('#id_fraccionamiento').val()+'/'+$('#id_manzana').val()+'/'+$('#id_lote').val());
    }});
    
    /*$('#ui-datepicker-div').click(function(){
        if($('#fecha').val() > 0)
           $(location).attr('href',url+'/'+$('#id_apartado').val()+'/'+$('#id_cliente').val()+'/'+$('#fecha').val());
    });*/
    /*
     * Autocompletado para el campo cliente
     */
    var separador = '{#####}';
    $('#txt_cliente').typeahead({
            minLength: 1,
            items: 10,
            source: function(query, process) {
                objects = [];
                clientes = {};
                var datos;

                $.post('<?php echo site_url("ventas/catalogos/clientes_autocompletar"); ?>', { q: query, limit: 10 }, function(data) {
                    datos = JSON.parse(data);

                    if (datos != false) {
                        $.each(datos, function(i, object) {
                            objects.push(object.id_cliente + separador + object.nombre);
                            clientes[object.id_cliente] = object;
                        });
                        process(objects);
                    }
                });
            },
            highlighter: function (item) {
                return item.split(separador)[1];
            },
            updater: function(item) {
                $('#id_cliente').val(clientes[item.split(separador)[0]].id_cliente);
                return item.split(separador)[1];
            }
    });
});
</script>