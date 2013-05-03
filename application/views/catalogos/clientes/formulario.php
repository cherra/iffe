<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2> 
        <?php echo $link_back; ?>
    </div>
</div>
<div class="row-fluid">
  <div class="span12">
    <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
       <!-- <div class="control-group">
        <div class="controls">
          <input type="hidden" name="id_cliente">
        </div>
      </div> -->
      <div class="control-group">
        <label class="control-label hidden-phone" for="nombre">Nombre</label>
        <div class="controls">
          <input type="text" name="nombre" id="nombre" class="required" placeholder="Nombre" value="<?php echo (isset($cliente->nombre) ? $cliente->nombre : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="apellido_paterno">Apellido Paterno</label>
        <div class="controls">
          <input type="text" name="apellido_paterno" class="required" placeholder="Apellido Paterno" value="<?php echo (isset($cliente->apellido_paterno) ? $cliente->apellido_paterno : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="apellido_materno">Apellido Materno</label>
        <div class="controls">
          <input type="text" name="apellido_materno" class="required" placeholder="Apellido Materno" value="<?php echo (isset($cliente->apellido_materno) ? $cliente->apellido_materno : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="calle">Calle</label>
        <div class="controls">
          <input type="text" name="calle" class="required" placeholder="Calle" value="<?php echo $variable = (isset($cliente->calle) ? $cliente->calle : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="numero_exterior">Numero Exterior</label>
        <div class="controls">
          <input type="text" maxlength="10" class="required" name="numero_exterior" placeholder="Numero Exterior" value="<?php echo (isset($cliente->numero_exterior) ? $cliente->numero_exterior : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="numero_interior">Numero Interior</label>
        <div class="controls">
          <input type="text" maxlength="10" name="numero_interior" placeholder="Numero Interior" value="<?php echo (isset($cliente->numero_interior) ? $cliente->numero_interior : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="colonia">Colonia</label>
        <div class="controls">
          <input type="text" name="colonia" class="required" placeholder="Colonia" value="<?php echo (isset($cliente->colonia) ? $cliente->colonia : ''); ?>">
        </div>
      </div>
       <div class="control-group">
        <label class="control-label hidden-phone" for="ciudad">Ciudad</label>
        <div class="controls">
          <input type="text" name="ciudad" class="required" placeholder="Ciudad" value="<?php echo (isset($cliente->ciudad) ? $cliente->ciudad : ''); ?>">
        </div>
      </div>
       <div class="control-group">
        <label class="control-label hidden-phone" for="estado">Estado</label>
        <div class="controls">
          <input type="text" name="estado" class="required" placeholder="Estado" value="<?php echo (isset($cliente->estado) ? $cliente->estado : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="rfc">RFC</label>
        <div class="controls">
          <input type="text" maxlength="13" name="rfc" placeholder="RFC" value="<?php echo (isset($cliente->rfc) ? $cliente->rfc : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="curp">CURP</label>
        <div class="controls">
          <input type="text" name="curp" placeholder="CURP" value="<?php echo (isset($cliente->curp) ? $cliente->curp : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="telefono">Telefono</label>
        <div class="controls">
          <input type="text" maxlength="10" name="telefono" class="required" placeholder="Telefono" value="<?php echo (isset($cliente->telefono) ? $cliente->telefono : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="celular">Celular</label>
        <div class="controls">
          <input type="text" maxlength="10" name="celular" placeholder="Celular" value="<?php echo (isset($cliente->celular) ? $cliente->celular : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="email">E-mail</label>
        <div class="controls">
          <input type="text" name="email" placeholder="e-mail" value="<?php echo (isset($cliente->celular) ? $cliente->celular : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Guardar</button>
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

<script>
$(document).ready(function(){
    $('#nombre').focus();
});
</script>