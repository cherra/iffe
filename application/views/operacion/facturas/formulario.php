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
        <label class="control-label" for="id_recibo">Recibo</label>
        <div class="controls">
            <select id="id_recibo" class="required">
                <option value="0">Selecciona un recibo...</option>
                <?php
                foreach($recibos as $r){ ?>
                    <option value="<?php echo $r->id; ?>" <?php if(!empty($id_recibo) && $id_recibo == $r->id) echo "selected"; ?>><?php echo $r->numero; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="total">Importe:</label>
        <div class="controls">
            <input type="hidden" name="total" value="<?php if(isset($recibo)){ echo $recibo->total; } ?>" />
            <input type="text" id="total" disabled placeholder="Importe" value="<?php if(isset($recibo)){ echo $recibo->total; } ?>" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="serie">Serie:</label>
        <div class="controls">
            <input type="text" name="serie" id="serie" placeholder="Serie" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="folio">Folio:</label>
        <div class="controls">
            <input type="text" name="folio" id="folio" placeholder="Folio" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="fecha">Fecha:</label>
        <div class="controls">
            <input type="text" class="fecha" name="fecha" id="fecha" placeholder="Fecha" />
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
    var url = '<?php echo site_url('operacion/ventas/facturas_add'); ?>';
    $('#id_recibo').change(function(){
        document.location = url+'/'+$(this).val();
    });
});
</script>