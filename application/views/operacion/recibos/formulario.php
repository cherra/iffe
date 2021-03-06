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
        <label class="control-label" for="id_contrato">Contrato</label>
        <div class="controls">
            <input type="hidden" name="id_contrato" id="id_contrato" value="<?php if(isset($id_contrato)) echo $id_contrato; ?>"/>
            <input type="text" id="txt_contrato" autocomplete="off" value="<?php 
                if(isset($cliente) && isset($contrato)){
                    if($cliente->tipo == 'moral'){
                        echo $contrato->numero."/".$contrato->sufijo." ".$cliente->razon_social; 
                    }else{
                        echo $contrato->numero."/".$contrato->sufijo." ".$cliente->nombre." ".$cliente->apellido_paterno." ".$cliente->apellido_materno; 
                    }
                }?>" />
        </div>
      </div>
      <!-- <div class="control-group">
        <label class="control-label" for="id_contrato">Contrato</label>
        <div class="controls">
            <select name="id_contrato" id="id_contrato" class="required">
                <option value="0">Selecciona un contrato...</option>
                <?php
                foreach($contratos as $c){ ?>
                    <option value="<?php echo $c->id; ?>" <?php if(!empty($id_contrato) && $id_contrato == $c->id) echo "selected"; ?>><?php echo $c->numero."/".$c->sufijo." ".$c->cliente; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
      </div> -->
      <div class="control-group">
        <label class="control-label" for="total">Total</label>
        <div class="controls">
            <input type="text" placeholder="0.00" disabled value="<?php if(isset($total)) echo number_format($total,2,'.',','); ?>"/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="abonos">Abonos</label>
        <div class="controls">
            <input type="text" id="abonos" placeholder="0.00" disabled value="<?php if(!empty($abonos) || !empty($notas)) echo number_format(-$abonos-$notas,2,'.',','); ?>"/>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="saldo">Saldo</label>
        <div class="controls">
            <input type="hidden" id="saldo" value="<?php if(isset($saldo)) echo $saldo; ?>" />
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
    /*$('#id_contrato').change(function(){
        document.location = url+'/'+$(this).val();
    });
    */
    $('#tipo').change(function(){
        if($(this).val() === 'total'){
            $('#total').val($('#saldo').val());
        }
    });
    
    var saldo = new Number($('#saldo').val());
    $('form').validate({
        rules:{
            total:{
                required: true,
                number: true,
                max: saldo
            }
        }
    });
    
    /*
     * Autocompletado para el campo contrato
     */
    var separador = '{#####}';
    $('#txt_contrato').typeahead({
            minLength: 1,
            items: 10,
            source: function(query, process) {
                objects = [];
                contratos = {};
                var datos;

                $.post('<?php echo site_url("operacion/ventas/contratos_adeudo"); ?>', { q: query, limit: 10 }, function(data) {
                    datos = JSON.parse(data);

                    if (datos != false) {
                        $.each(datos, function(i, object) {
                            objects.push(object.id + separador + object.numero+'/'+object.sufijo+' '+object.cliente);
                            contratos[object.id] = object;
                        });
                    }
                    process(objects);
                });
            },
            highlighter: function (item) {
                return item.split(separador)[1];
            },
            updater: function(item) {
                //$('#id_contrato').val(contratos[item.split(separador)[0]].id);
                document.location = url+'/'+contratos[item.split(separador)[0]].id;
                /*$('#abonos').val(contratos[item.split(separador)[0]].abonos);
                $('#total').val(contratos[item.split(separador)[0]].total);
                saldo = Number(contratos[item.split(separador)[0]].total)-Number(contratos[item.split(separador)[0]].abonos);
                $('#saldo').val(saldo);
                alert(Number(contratos[item.split(separador)[0]].total)-Number(contratos[item.split(separador)[0]].abonos));*/
                //return item.split(separador)[1];
            }
    });
});
</script>