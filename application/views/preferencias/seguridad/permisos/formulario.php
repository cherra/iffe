<div class="row-fluid">
  <h3><?php echo $titulo; ?></h3> <?php echo $link_back; ?>
  <br/>
  <br/>
  <div class="span12">
    <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
      <div class="control-group">
        <label class="control-label" for="nombre">Nombre</label>
        <div class="controls">
          <input type="text" id="nombre" name="nombre" required value="<?php echo $variable = (isset($permiso->nombre) ? $permiso->nombre : ''); ?>" placeholder="Nombre">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="icon">Icono</label>
        <div class="controls">
          <input type="text" id="icon" name="icon" value="<?php echo $variable = (isset($permiso->icon) ? $permiso->icon : ''); ?>" placeholder="Icono">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="menu">En el menú?</label>
        <div class="controls">
          <input type="checkbox" id="menu" name="menu" value="1" <?php 
          if(isset($permiso->menu)){
              echo $permiso->menu == 1 ? 'checked' : ''; 
          }
          ?>>
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