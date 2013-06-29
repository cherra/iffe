<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2> 
        <?php echo $link_back; ?>
    </div>
</div>
<div class="row-fluid">
  <div class="span12">
    <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
      <?php if(isset($contrato)){ ?>
      <div class="control-group">
        <label class="control-label hidden-phone" for="numero">Número</label>
        <div class="controls">
            <input disabled type="text" id="numero" placeholder="Número" value="<?php if(!empty($contrato)) echo $contrato->numero; ?>"/>
        </div>
      </div>
      <?php } ?>
      <div class="control-group">
        <label class="control-label hidden-phone" for="txt_cliente">Buscar cliente</label>
        <div class="controls">
            <input type="text" id="txt_cliente" placeholder="Buscar cliente..." value="<?php if(!empty($cliente)) echo $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno; ?>" autocomplete="off" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="id_cliente">Cliente seleccionado</label>
        <div class="controls">
            <input type="text" name="id_cliente" class="input-mini required" placeholder="Id" id="id_cliente" value="<?php echo (!empty($cliente) ? $cliente->id : ''); ?>" readonly/>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
            <input type="text" id="cliente" placeholder="Nombre" value="<?php if(!empty($cliente)) echo $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno; ?>" readonly />  
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="fecha_inicio">Fecha de inicio</label>
        <div class="controls">
            <input type="hidden" name="fecha_inicio" value="<?php echo (isset($contrato) ? $contrato->fecha_inicio : $periodo->fecha_inicio); ?>">
            <input class="fecha date" disabled type="text" value="<?php echo (isset($contrato) ? $contrato->fecha_inicio : $periodo->fecha_inicio); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="fecha_vencimiento">Fecha de vencimiento</label>
        <div class="controls">
            <input type="hidden" name="fecha_vencimiento" value="<?php echo (isset($contrato) ? $contrato->fecha_vencimiento : $periodo->fecha_fin); ?>">
            <input class="fecha" disabled type="text" value="<?php echo (isset($contrato) ? $contrato->fecha_vencimiento : $periodo->fecha_fin); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="testigo1">Testigo 1:</label>
        <div class="controls">
            <input type="text" name="testigo1" class="required" id="testigo1" placeholder="Testigo 1" value="<?php echo (isset($contrato) ? $contrato->testigo1 : ''); ?>"/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="testigo2">Testigo 2:</label>
        <div class="controls">
            <input type="text" name="testigo2" class="required" id="testigo2" placeholder="Testigo 2" value="<?php echo (isset($contrato) ? $contrato->testigo2 : ''); ?>"/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="observaciones">Observaciones</label>
        <div class="controls">
          <textarea name="observaciones" 
                    id="observaciones" 
                    placeholder="Observaciones" 
                    rows="5"><?php echo (isset($contrato) ? $contrato->observaciones : ''); ?></textarea>
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
    //$('#txt_cliente').focus();

    /*
     * Autocompletado para el campo cliente
     */
    var separador = '{#####}';
    $('#txt_cliente').typeahead({
            minLength: 2,
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
                    }
                    process(objects);
                });
            },
            highlighter: function (item) {
                return item.split(separador)[1];
            },
            updater: function(item) {
                $('#id_cliente').val(clientes[item.split(separador)[0]].id);
                $('#cliente').val(clientes[item.split(separador)[0]].nombre);
                return item.split(separador)[1];
            }
    });
});
</script>