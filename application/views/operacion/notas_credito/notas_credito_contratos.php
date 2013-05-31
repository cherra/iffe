<div class="row-fluid">
  <div class="page-header">
    <h2><?php echo $titulo; ?></h2>
      <?php echo $link_back; ?>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-condensed">
            <tr class="info">
                <td><strong>Serie</strong></td>
                <td><strong>Folio</strong></td>
                <td><strong>Cliente</strong></td>
                <td><strong>Fecha</strong></td>
            </tr>
            <?php if(!empty($nota)): ?>
            <tr>
                <td><?php echo $nota->serie; ?></td>
                <td><?php echo $nota->folio; ?></td>
                <td><?php echo $nota->nombre; ?></td>
                <td><?php echo $nota->fecha; ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        
    
<?php echo form_open($action, array('class' => 'form-horizontal')); ?>
    <input type="hidden" id="id_nota_credito" name="id_nota_credito" value="<?php echo $nota->id; ?>"/>
    <div class="control-group">
        <label class="control-label" for="id_contrato">Contrato</label>
        <div class="controls">
            <input type="hidden" name="id_contrato" id="id_contrato" value="<?php if(isset($contrato)) echo $contrato->id; ?>"/>
            <input type="text" id="txt_contrato" autocomplete="off" value="<?php if(isset($cliente) && isset($contrato)) echo $contrato->numero."/".$contrato->sufijo." ".$cliente->nombre." ".$cliente->apellido_paterno." ".$cliente->apellido_materno; ?>" />
        </div>
      </div>
    <div class="control-group">
        <label class="control-label" for="descuento">Descuento</label>
        <div class="controls">
            <div class="input-append">
                <input type="text" id="descuento" name="descuento" class="required span11" />
                <span class="add-on">%</span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary" <?php if(empty($contrato)) echo "disabled"; ?>>Agregar</button>
        </div>
    </div>
<?php echo form_close(); ?>
</div>
</div>


<div class="row-fluid">
    <div class="span12">
        <div class="data"><?php echo $table; ?></div>
    </div>
</div>

<div class="row-fluid">
  	<div class="span6 offset3">
    	<?php echo $mensaje ?>
	</div>
</div>

<script type="text/javascript">
$(function () {
    $('form').validate({
        rules:{
            descuento:{
                required: true,
                number: true,
                max: 100
            }
        }
    });
    
    var url = "<?php echo site_url('operacion/administracion/notas_credito_contratos/'.$nota->id); ?>";
    
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
                        process(objects);
                    }
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