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
        <label class="control-label hidden-phone" for="serie">Serie</label>
        <div class="controls">
            <input type="text" name="serie" id="serie" placeholder="Serie" value="<?php echo (!empty($nota)) ? $nota->serie : $serie; ?>"/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="folio">Folio</label>
        <div class="controls">
            <input type="text" name="folio" id="folio" class="required" placeholder="Serie" value="<?php echo (!empty($nota)) ? $nota->folio : $folio; ?>"/>
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
            <input class="fecha" type="text" name="fecha" value="<?php echo (!empty($nota) ? $nota->fecha : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="concepto">Descripción</label>
        <div class="controls">
          <textarea name="concepto" 
                    id="concepto" 
                    placeholder="Descripción" 
                    rows="10"><?php echo (isset($nota) ? $nota->concepto : ''); ?></textarea>
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
                return item.split(separador)[1];
            }
    });
});
</script>