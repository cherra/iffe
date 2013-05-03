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
                <label class="control-label hidden-phone">Fraccionamiento</label>
                <div class="controls">
                    <input type="text" disabled value="<?php echo (isset($fraccionamiento) ? $fraccionamiento->descripcion : ''); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="descripcion">Descripción</label>
                <div class="controls">
                    <input type="text" id="descripcion" name="descripcion" class="required" value="<?php echo $variable = (isset($manzana->descripcion) ? $manzana->descripcion : ''); ?>" placeholder="Descripción">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="observaciones">Observaciones</label>
                <div class="controls">
                    <textarea name="observaciones" id="observaciones" class=""required" placeholder="Observaciones" rows="5"><?php echo $variable = (isset($manzana->observaciones) ? $manzana->observaciones : ''); ?></textarea>
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
   
    $('#descripcion').focus();
    
});

</script>