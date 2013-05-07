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
                <td class="hidden-phone"><strong>Cliente</strong></td>
                <td><strong>Fraccionamiento</strong></td>
                <td><strong>Manzana</strong></td>
                <td><strong>Lote</strong></td>
                <td class="hidden-phone"><strong>Fecha</strong></td>
            </tr>
            <tr>
                <td class="hidden-phone"><?php echo $contrato->cliente; ?></td>
                <td><?php echo $contrato->fraccionamiento; ?></td>
                <td><?php echo $contrato->manzana; ?></td>
                <td><?php echo $contrato->lote; ?></td>
                <td class="hidden-phone"><?php echo $contrato->fecha; ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <?php echo form_open_multipart($action, array('class' => 'form-horizontal', 'id' => 'form', 'name' => 'form'));?>

            <div class="control-group">
                <label class="control-label hidden-phone" for="descripcion">Descripcion</label>
                <div class="controls">
                    <input type="text" id="descripcion" name="descripcion" class="required" value="<?php if(!empty($adjunto)) echo $adjunto->descripcion; ?>" placeholder="Descripcion">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="observaciones">Observaciones</label>
                <div class="controls">
                    <input type="text" id="observaciones" name="observaciones" class="required" value="<?php if(!empty($adjunto)) echo $adjunto->observaciones; ?>" placeholder="Observaciones">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label hidden-phone" for="path">Archivo</label>
                <div class="controls">
                    <?php
                    if(!empty($adjunto)){
                    ?>
                    <input type="text" id="path" disabled value="<?php echo $adjunto->file_name; ?>" />
                    <?php
                    }else{
                    ?>
                    <input type="file" name="path" id="path" required placeholder="Archivo" />
                    <?php
                    }
                    ?>
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
        <div class="span8">
            <?php echo $mensaje ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    
$(function () {
   
    $('#descripcion').focus();
    
});

</script>