<div class="row-fluid">
  <h3><?php echo $titulo; ?></h3> <?php echo $link_back; ?>
  <br/>
  <br/>
  <div class="span12">
    <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
      <div class="control-group">
        <label class="control-label" for="nombre">Nombre</label>
        <div class="controls">
          <input type="text" id="nombre" name="nombre" required value="<?php echo $variable = (isset($rol->nombre) ? $rol->nombre : ''); ?>" placeholder="Nombre">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="descripcion">Descripción</label>
        <div class="controls">
          <textarea name="descripcion" id="descripcion" required placeholder="Descripcion" rows="5"><?php echo $variable = (isset($rol->descripcion) ? $rol->descripcion : ''); ?></textarea>
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
  <div class="span6 offset3">
    <?php echo $mensaje ?>
  </div>
</div>