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
                <td><strong>Número</strong></td>
                <td><strong>Cliente</strong></td>
                <td><strong>Fecha</strong></td>
                <td><strong>Fecha de Vencimiento</strong></td>
            </tr>
            <?php if(!empty($contrato)): ?>
            <tr>
                <td><?php echo $contrato->numero; ?></td>
                <td><?php echo (!empty($cliente)) ? $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno : '-'; ?></td>
                <td><?php echo $contrato->fecha_inicio; ?></td>
                <td><?php echo $contrato->fecha_vencimiento; ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<?php echo form_open($action, array('class' => 'form-horizontal')); ?>
    <input type="hidden" id="id_contrato" name="id_contrato" value="<?php echo $contrato->id; ?>"/>
    <div class="control-group">
        <label class="control-label" for="id_calle">Calle</label>
        <div class="controls">
            <select id="id_calle" class="required">
                <option value="0">Selecciona una calle...</option>
                <?php
                foreach($calles as $c){ ?>
                    <option value="<?php echo $c->id; ?>" <?php if(!empty($calle)) echo ($calle->id == $c->id ? 'selected' : ''); ?>><?php echo $c->nombre; ?></option>
                <?php
                }
                ?>
            </select>
            <small>Precio base: <?php if(!empty($calle)) echo number_format($calle->precio_base * ( 1 + $this->configuracion->get_valor('iva') ),2); ?></small>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="id_modulo">Módulos</label>
        <div class="controls">
            <!-- <select id="id_modulo" name="id_modulo" class="required" <?php if(empty($calle)) echo "disabled"; ?>>
                <option value="0">Selecciona un módulo...</option>
                <?php
                foreach($modulos as $m){ ?>
                    <option value="<?php echo $m->id; ?>" <?php if(!empty($modulo)) echo ($modulo->id == $m->id ? 'selected' : ''); ?>><?php echo $m->numero; ?></option>
                <?php
                }
                ?>
        </select> -->
            <input type="text" name="modulos" id="modulos" placeholder="Módulos (ej. 1-3, 5, 7-10)" <?php if(empty($calle)) echo "disabled"; ?>/>
            <small>Disp: <?php if(!empty($modulos)) echo $modulos; ?></small>
        </div>
    </div>
    <!-- <div class="control-group">
        <label class="control-label" for="precio">Precio</label>
        <div class="controls">
            <input type="hidden" name="subtotal" value="<?php if(!empty($modulo) ) echo number_format($modulo->precio,2,'.',''); ?>" />
            <input type="text" id="precio" value="<?php if(!empty($modulo) ) echo number_format($modulo->precio,2,'.',','); ?>" disabled/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="iva">IVA</label>
        <div class="controls">
            <input type="text" id="iva" value="<?php if(!empty($modulo) ) echo number_format($modulo->precio * $this->configuracion->get_valor('iva'),2,'.',','); ?>" disabled/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="importe">Importe</label>
        <div class="controls">
            <input type="text" id="importe" value="<?php if(!empty($modulo) ) echo number_format($modulo->precio * (1 + $this->configuracion->get_valor('iva')),2,'.',','); ?>" disabled />
        </div>
    </div> -->
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
    </div>
<?php echo form_close(); ?>



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
	$('#form').validate();
        
        var url = "<?php echo site_url('operacion/ventas/contratos_modulos'); ?>";
        $('#id_calle').change(function(){
            //if($(this).val() > 0)
                $(location).attr('href',url+'/'+$('#id_contrato').val()+'/'+$(this).val());
        });
        
        $('#modulos').focus();
});
</script>