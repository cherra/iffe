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
                <label class="control-label hidden-phone" for="nombre">Nombre</label>
                <div class="controls">
                    <input type="text" id="nombre" name="nombre" class="required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="descripcion">Descripción</label>
                <div class="controls">
                    <input type="text" id="descripcion" name="descripcion" class="required" value="<?php echo (isset($datos->descripcion) ? $datos->descripcion : ''); ?>" placeholder="Descripción">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="precio_base">Precio base <small>(sin IVA)</small></label>
                <div class="controls">
                    <input type="text" id="precio_base" name="precio_base" class="required number" value="<?php echo (isset($datos->precio_base) ? $datos->precio_base : ''); ?>" placeholder="Precio base">
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