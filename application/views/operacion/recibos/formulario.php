<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2> 
        <?php echo $link_back; ?>
    </div>
</div>
<div class="row-fluid">
  <div class="span12">
    <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
        <input type="hidden" id="saldo" value="<?php if(isset($saldo)) echo $saldo; ?>" />
      <div class="control-group">
        <label class="control-label" for="id_contrato">Contrato</label>
        <div class="controls">
            <select name="id_contrato" id="id_contrato" class="required">
                <option value="0">Selecciona un contrato...</option>
                <?php
                foreach($contratos as $c){ ?>
                    <option value="<?php echo $c->id; ?>" <?php if(!empty($id_contrato) && $id_contrato == $c->id) echo "selected"; ?>><?php echo $c->numero."/".$c->sufijo; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="total">Total</label>
        <div class="controls">
            <input type="text" id="total" placeholder="0.00" disabled value="<?php if(isset($total)) echo number_format($total,2,'.',','); ?>"/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="abonos">Abonos</label>
        <div class="controls">
            <input type="text" id="abonos" placeholder="0.00" disabled value="<?php if(isset($abonos)) echo number_format(-$abonos,2,'.',','); ?>"/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="saldo">Saldo</label>
        <div class="controls">
            <input type="text" placeholder="0.00" disabled value="<?php if(isset($saldo)) echo number_format($saldo,2,'.',','); ?>"/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="tipo">Tipo</label>
        <div class="controls">
            <select name="tipo" id="tipo" class="required">
                <option value="anticipo">Anticipo</option>
                <option value="total">Pago total</option>
            </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="total">Importe:</label>
        <div class="controls">
            <input type="text" name="total" id="total" placeholder="Importe" />
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
    var url = '<?php echo site_url('operacion/ventas/recibos_add'); ?>';
    $('#id_contrato').change(function(){
        document.location = url+'/'+$(this).val();
    });
    
    var saldo = Number($('#saldo').val());
    $('form').validate({
        rules:{
            total:{
                required: true,
                number: true,
                max: saldo
            }
        }
    });
});
</script>