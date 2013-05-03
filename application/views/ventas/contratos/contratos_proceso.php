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
                <td><strong>Fraccionamiento</strong></td>
                <td><strong>Manzana</strong></td>
                <td><strong>Lote</strong></td>
                <td class="hidden-phone"><strong>Cliente</strong></td>
                <td class="hidden-phone"><strong>Fecha</strong></td>
                <td class="hidden-phone"><strong>Fecha de Vencimiento</strong></td>
            </tr>
            <?php if(!empty($contrato)): ?>
            <tr>
                <td><?php echo $contrato->fraccionamiento; ?></td>
                <td><?php echo $contrato->manzana; ?></td>
                <td><?php echo $contrato->lote; ?></td>
                <td class="hidden-phone"><?php echo $contrato->cliente; ?></td>
                <td class="hidden-phone"><?php echo $contrato->fecha; ?></td>
                <td class="hidden-phone"><?php echo $contrato->fecha_vencimiento; ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
            <div class="control-group">
                <label class="control-label" for="id_proceso">Procesos</label>
            <div class="controls">
                <select name="id_proceso" id="id_proceso" class="required">
                <option value="">Selecciona un proceso...</option>
                <?php if ($procesos_not) : ?>
                    <?php foreach($procesos_not as $proceso) : ?>
                    <option
                            value="<?php echo $proceso->id_proceso; ?>" 
                            <?php if(!empty($id_proceso)) echo ($id_proceso == $proceso->id_proceso ? "selected" : ""); ?>
                    ><?php echo $proceso->descripcion; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
                </select>
                <input type="hidden" name="id_contrato" value="<?php echo $contrato->id_contrato; ?>" />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                  <button type="submit" id="guardar" class="btn btn-primary">Agregar</button>
                </div>
            </div> 
        </form>
    </div>
</div>

<div class="row-fluid">
  	<div class="span6 offset3">
    	<?php echo $mensaje ?>
	</div>
</div>

<div class="row-fluid">
  	<div class="span12">
    	<table class="table table-condensed">
    		<tr class="info">
    			<td><strong>Procesos</strong></td>
    		</tr>
    		<?php if ($procesos) : ?>
	    		<?php foreach($procesos as $proceso) : ?>
	    		<tr>
	    			<td><?php echo $proceso->descripcion; ?></td>
	    		</tr>
				<?php endforeach; ?>
			<?php endif; ?>
    	</table>
	</div>
</div>

<script type="text/javascript">
$(function () {
	$('#form').validate();
});
</script>