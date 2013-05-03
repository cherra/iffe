<div class="row-fluid">
  <h3><?php echo $titulo; ?></h3> <?php echo $link_back; ?>
  <br/>
  <br/>
  <div class="span12">
    <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
      <div class="control-group">
        <label class="control-label hidden-phone" for="descripcion">Descripción</label>
        <div class="controls">
          <input type="text" 
                 id="descripcion" 
                 name="descripcion" 
                 class="required" 
                 value="<?php echo (isset($fraccionamiento->descripcion) ? $fraccionamiento->descripcion : ''); ?>" 
                 placeholder="Descripción">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="poblacion">Población</label>
        <div class="controls">
          <input type="text" 
                 id="poblacion" 
                 name="poblacion" 
                 class="required" 
                 value="<?php echo (isset($fraccionamiento->poblacion) ? $fraccionamiento->poblacion : ''); ?>" 
                 placeholder="Población">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="ciudad">Ciudad</label>
        <div class="controls">
          <input type="text" 
                 id="ciudad" 
                 name="ciudad" 
                 class="required" 
                 value="<?php echo (isset($fraccionamiento->ciudad) ? $fraccionamiento->ciudad : ''); ?>" 
                 placeholder="Ciudad">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="estado">Estado</label>
        <div class="controls">
          <input type="text" 
                 id="estado" 
                 name="estado" 
                 class="required" 
                 value="<?php echo (isset($fraccionamiento->estado) ? $fraccionamiento->estado : ''); ?>" 
                 placeholder="Estado">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="observaciones">Observaciones</label>
        <div class="controls">
          <textarea name="observaciones" 
                    id="observaciones" 
                    class="required" 
                    placeholder="Observaciones" 
                    rows="5"><?php echo (isset($fraccionamiento->observaciones) ? $fraccionamiento->observaciones : ''); ?></textarea>
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
   
    $('#descripcion').focus();
    
});

</script>