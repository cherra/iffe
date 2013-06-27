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
        <label class="control-label" for="nombre">Nombre</label>
        <div class="controls">
          <input type="text" id="nombre" name="nombre" required value="<?php echo $variable = (isset($usuario->nombre) ? $usuario->nombre : ''); ?>" placeholder="Nombre">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="username">Nombre de usuario</label>
        <div class="controls">
          <input type="text" id="username" name="username" required value="<?php echo $variable = (isset($usuario->username) ? $usuario->username : ''); ?>" placeholder="Nombre de usuario" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="password">Contraseña</label>
        <div class="controls">
          <input type="password" id="password" name="password" value="" placeholder="Contraseña" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="confirmar_password">Contraseña</label>
        <div class="controls">
          <input type="password" id="confirmar_password" name="confirmar_password" value="" placeholder="Confirmar contraseña" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="activo">Activo?</label>
        <div class="controls">
          <input type="checkbox" id="activo" name="activo" value="s" <?php 
          if(isset($usuario->activo)){
              echo $usuario->activo == 's' ? 'checked' : ''; 
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