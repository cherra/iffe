<div class="row-fluid">
  <h3><?php echo $titulo; ?></h3> <?php echo $link_back; ?>
  <br/>
  <br/>
  <div class="span12">
    <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
      <div class="control-group">
        <label class="control-label" for="password">Nueva contraseña</label>
        <div class="controls">
          <input type="password" id="password" name="password" value="" placeholder="Contraseña" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="confirmar_password">Confirmar contraseña</label>
        <div class="controls">
          <input type="password" id="confirmar_password" name="confirmar_password" value="" placeholder="Confirmar contraseña" autocomplete="off">
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