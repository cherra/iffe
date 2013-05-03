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
                <label class="control-label hidden-phone" >Fraccionamiento</label>
                <div class="controls">
                    <input type="text" disabled value="<?php echo (isset($fraccionamiento) ? $fraccionamiento->descripcion : ''); ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone">Manzana</label>
                <div class="controls">
                    <input type="text" disabled value="<?php echo (isset($manzana) ? $manzana->descripcion : ''); ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="id_categoria">Categoría</label>
                <div class="controls">
                    <select name="id_categoria" class="required">
                        <option value="">Selecciona una Categoría...</option>
                        <?php foreach($categorias as $c): ?>
                        <option value="<?php echo $c->id; ?>" <?php echo (isset($lote) && $c->id == $lote->id_categoria ) ? 'selected="selected"' : ''; ?>>
                          <?php echo $c->descripcion; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="descripcion">Descripción</label>
                <div class="controls">
                    <input type="text" id="descripcion" name="descripcion" class="required" value="<?php echo (isset($lote->descripcion) ? $lote->descripcion : ''); ?>" placeholder="Descripción">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="superficie">Superficie</label>
                <div class="controls">
                    <input type="text" id="superficie" name="superficie" class="required number" value="<?php echo (isset($lote->superficie) ? $lote->superficie : ''); ?>" placeholder="Superficie en m2">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="frente">Frente</label>
                <div class="controls">
                    <input type="text" id="frente" name="frente" class="required number" value="<?php echo (isset($lote->frente) ? $lote->frente : ''); ?>" placeholder="Frente en m">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="fondo">Fondo</label>
                <div class="controls">
                    <input type="text" id="fondo" name="fondo" class="required number" value="<?php echo (isset($lote->fondo) ? $lote->fondo : ''); ?>" placeholder="Fondo en m">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="calle">Calle</label>
                <div class="controls">
                    <input type="text" id="calle" name="calle" value="<?php echo (isset($lote->calle) ? $lote->calle : ''); ?>" placeholder="Calle">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="numero">Número</label>
                <div class="controls">
                    <input type="text" id="numero" name="numero" class="number" value="<?php echo (isset($lote->numero) ? $lote->numero : ''); ?>" placeholder="Número">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="clave_catastral">Clave catastral</label>
                <div class="controls">
                    <input type="text" id="clave_catastral" name="clave_catastral" value="<?php echo (isset($lote->clave_catastral) ? $lote->clave_catastral : ''); ?>" placeholder="Clave catastral">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="observaciones">Observaciones</label>
                <div class="controls">
                    <textarea name="observaciones" id="observaciones" placeholder="Observaciones" rows="3"><?php echo (isset($lote->observaciones) ? $lote->observaciones : ''); ?></textarea>
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