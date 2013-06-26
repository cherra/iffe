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
                <label class="control-label hidden-phone">Calle</label>
                <div class="controls">
                    <input type="text" disabled value="<?php echo (isset($calle) ? $calle->nombre : ''); ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="numero">Número</label>
                <div class="controls">
                    <input type="text" id="numero" name="numero" class="required" value="<?php echo (isset($datos->numero) ? $datos->numero : ''); ?>" placeholder="Número">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="frente">Frente</label>
                <div class="controls">
                    <input type="text" id="frente" name="frente" class="required number" value="<?php echo (isset($datos->frente) ? $datos->frente : ''); ?>" placeholder="Frente en m">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="fondo">Fondo</label>
                <div class="controls">
                    <input type="text" id="fondo" name="fondo" class="required number" value="<?php echo (isset($datos->fondo) ? $datos->fondo : ''); ?>" placeholder="Fondo en m">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="precio">Precio <small>(sin IVA)</small></label>
                <div class="controls">
                    <input type="text" id="precio" name="precio" class="required number" value="<?php echo (isset($datos->precio) ? $datos->precio : $calle->precio_base); ?>" placeholder="Precio">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="categoria">Categoría</label>
                <div class="controls">
                    <select id="categoria" name="categoria">
                        <option value="local" <?php echo (isset($datos) && $datos->categoria == 'local' ? 'selected' : ''); ?>>Local</option>
                        <option value="metro" <?php echo (isset($datos) && $datos->categoria == 'metro' ? 'selected' : ''); ?>>Metro</option>
                        <option value="modulo" <?php echo (isset($datos) && $datos->categoria == 'modulo' ? 'selected' : ''); ?>>Módulo</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="tipo">Tipo</label>
                <div class="controls">
                    <select id="tipo" name="tipo">
                        <option value="intermedio" <?php echo (isset($datos) && $datos->tipo == 'intermedio' ? 'selected' : ''); ?>>Intermedio</option>
                        <option value="esquina" <?php echo (isset($datos) && $datos->tipo == 'esquina' ? 'selected' : ''); ?>>Esquina</option>
                        <option value="otro" <?php echo (isset($datos) && $datos->tipo == 'otro' ? 'selected' : ''); ?>>Otro</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="descripcion">Descripción</label>
                <div class="controls">
                    <input type="text" id="descripcion" name="descripcion" value="<?php echo (isset($datos->descripcion) ? $datos->descripcion : ''); ?>" placeholder="Descripción">
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
$(document).ready(function(){
    $('#numero').focus();
});
</script>