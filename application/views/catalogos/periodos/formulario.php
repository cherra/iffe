<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
        <?php echo $link_back; ?>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
            <input type="hidden" name="activo" value="<?php echo (isset($datos->activo) ? $datos->activo : '1') ?>" />
            <div class="control-group">
                <label class="control-label hidden-phone" for="nombre">Nombre</label>
                <div class="controls">
                    <input type="text" id="nombre" name="nombre" class="required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="fecha_inicio">Fecha de inicio</label>
                <div class="controls">
                    <input type="text" id="fecha_inicio" name="fecha_inicio" class="required fecha" value="<?php echo (isset($datos->fecha_inicio) ? $datos->fecha_inicio : ''); ?>" placeholder="Fecha de inicio">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="fecha_fin">Fecha de fin</label>
                <div class="controls">
                    <input type="text" id="fecha_fin" name="fecha_fin" class="required fecha" value="<?php echo (isset($datos->fecha_fin) ? $datos->fecha_fin : ''); ?>" placeholder="Fecha de fin">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="observaciones">Observaciones</label>
                <div class="controls">
                    <input type="text" id="observaciones" name="observaciones" value="<?php echo (isset($datos->observaciones) ? $datos->observaciones : ''); ?>" placeholder="Observaciones">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>     
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?php echo $mensaje ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>