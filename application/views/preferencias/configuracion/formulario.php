<div class="row-fluid">
  <h3><?php echo $titulo; ?></h3> <?php echo $link_back; ?>
  <br/>
  <br/>
  <div class="span12">
    <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
      <div class="control-group">
        <label class="control-label" for="key">Key</label>
        <div class="controls">
          <input type="text" id="key" name="key" required value="<?php echo $variable = (isset($parametro->key) ? $parametro->key : ''); ?>" placeholder="Key" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="valor">Valor</label>
        <div class="controls">
          <input type="text" id="valor" name="valor" required value="<?php echo $variable = (isset($parametro->valor) ? $parametro->valor : ''); ?>" placeholder="Valor" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="descripcion">Descripción</label>
        <div class="controls">
          <textarea name="descripcion" 
                    id="descripcion" 
                    required 
                    placeholder="Descripción" 
                    rows="5"><?php echo $variable = (isset($parametro->descripcion) ? $parametro->descripcion : ''); ?></textarea>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="row-fluid">
  <div class="span6">
    <?php echo $mensaje ?>
  </div>
</div>
<script type="text/javascript">
    
$(function () {
   
    $('#key').focus();
});

</script>