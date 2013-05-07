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
        <label class="control-label hidden-phone" for="id_calle">Calle</label>
        <div class="controls">
          <select name="id_calle" id="id_calle" class="required">
            <option value="0">Selecciona una Calle...</option>
            <?php foreach ($calles as $c){ ?>
                <option value="<?php echo $c->id; ?>" <?php if(!empty($id_calle)) echo ($id_calle == $c->id ? "selected" : ""); ?>><?php echo $c->nombre; ?></option>
            <?php
              }
            ?>
          </select>
        </div>
      </div>
        
      <div class="control-group">
        <label class="control-label hidden-phone" for="id_modulo">Módulo</label>
        <div class="controls">
          <select name="id_modulo" id="id_modulo" class="required" <?php if(!isset($id_calle)) echo "disabled"; ?>>
            <option value="">Selecciona un Módulo...</option>
            <?php foreach($modulos as $m){ ?>
                <option value="<?php echo $m->id; ?>" <?php if(!empty($id_modulo)) echo ($id_modulo == $m->id ? "selected" : ""); ?>><?php echo $m->numero; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="control-group">
          <label class="control-label hidden-phone">Precio</label>
          <div class="controls">
            <div class="input-prepend">
                <span class="add-on">$</span>
                <input type="text" class="span11" disabled value="<?php echo (!empty($modulo->precio) ? number_format($modulo->precio,2,'.',',') : ''); ?>"/>
            </div>
          </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="txt_cliente">Cliente</label>
        <div class="controls">
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo (!empty($cliente) ? $cliente->id : '0'); ?>"/>
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
                    rows="5"><?php echo (isset($contrato->observaciones) ? $contrato->observaciones : ''); ?></textarea>
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
    $('#id_calle').change(function(){
        if($(this).val() > 0)
           $(location).attr('href',url+'/'+$(this).val()+'/'+$('#id_modulo').val()+'/'+$('#id_cliente').val()+'/'+$('#fecha').val());
    });
    
    $('#id_modulo').change(function(){
        if($(this).val() > 0)
           $(location).attr('href',url+'/'+$('#id_calle').val()+'/'+$(this).val()+'/'+$('#id_cliente').val()+'/'+$('#fecha').val());
    });
    
    $('#fecha').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        onSelect: function(dateText){
            $(location).attr('href',url+'/'+$('#id_calle').val()+'/'+$('#id_modulo').val()+'/'+$('#id_cliente').val()+'/'+dateText);
    }});

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

                $.post('<?php echo site_url("catalogos/clientes/autocompletar"); ?>', { q: query, limit: 10 }, function(data) {
                    datos = JSON.parse(data);

                    if (datos != false) {
                        $.each(datos, function(i, object) {
                            objects.push(object.id + separador + object.nombre);
                            clientes[object.id] = object;
                        });
                        process(objects);
                    }
                });
            },
            highlighter: function (item) {
                return item.split(separador)[1];
            },
            updater: function(item) {
                $('#id_cliente').val(clientes[item.split(separador)[0]].id);
                return item.split(separador)[1];
            }
    });
});
</script>