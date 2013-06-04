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
        <label class="control-label hidden-phone" for="id_giro">Giro</label>
        <div class="controls">
            <select name="id_giro" class="required">
                <option value="">Selecciona un giro...</option>
                <?php foreach ($giros as $giro){ ?>
                <option value="<?php echo $giro->id; ?>" <?php if( isset($datos->id_giro) && ($datos->id_giro == $giro->id) ) echo "selected"; ?>><?php echo $giro->nombre; ?></option>
                <?php } ?>
            </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="id_concesion">Concesión</label>
        <div class="controls">
            <select name="id_concesion" class="required">
                <option value="">Selecciona una concesión...</option>
                <?php foreach ($concesiones as $concesion){ ?>
                <option value="<?php echo $concesion->id; ?>" <?php if( isset($datos->id_concesion) && ($datos->id_concesion == $concesion->id) ) echo "selected"; ?>><?php echo $concesion->nombre; ?></option>
                <?php } ?>
            </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="tipo">Persona</label>
        <div class="controls">
            <select name="tipo" id="tipo" class="required">
                <option value="fisica" <?php if( isset($datos->tipo) && ($datos->tipo == 'fisica') ) echo "selected"; ?>>Física</option>
                <option value="moral" <?php if( isset($datos->tipo) && ($datos->tipo == 'moral') ) echo "selected"; ?>>Moral</option>
            </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="razon_social">Razón social</label>
        <div class="controls">
          <input type="text" name="razon_social" id="razon_social" placeholder="Razón social" value="<?php echo (isset($datos->razon_social) ? $datos->razon_social : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="nombre">Nombre</label>
        <div class="controls">
          <input type="text" name="nombre" id="nombre" class="required" placeholder="Nombre" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="apellido_paterno">Apellido Paterno</label>
        <div class="controls">
          <input type="text" name="apellido_paterno" class="required" placeholder="Apellido Paterno" value="<?php echo (isset($datos->apellido_paterno) ? $datos->apellido_paterno : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="apellido_materno">Apellido Materno</label>
        <div class="controls">
          <input type="text" name="apellido_materno" class="required" placeholder="Apellido Materno" value="<?php echo (isset($datos->apellido_materno) ? $datos->apellido_materno : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="calle">Calle</label>
        <div class="controls">
          <input type="text" name="calle" class="required" placeholder="Calle" value="<?php echo (isset($datos->calle) ? $datos->calle : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="numero_exterior">Numero Exterior</label>
        <div class="controls">
          <input type="text" maxlength="10" name="numero_exterior" placeholder="Numero Exterior" value="<?php echo (isset($datos->numero_exterior) ? $datos->numero_exterior : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="numero_interior">Numero Interior</label>
        <div class="controls">
          <input type="text" maxlength="10" name="numero_interior" placeholder="Numero Interior" value="<?php echo (isset($datos->numero_interior) ? $datos->numero_interior : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="colonia">Colonia</label>
        <div class="controls">
          <input type="text" name="colonia" class="required" placeholder="Colonia" value="<?php echo (isset($datos->colonia) ? $datos->colonia : ''); ?>">
        </div>
      </div>
       <div class="control-group">
        <label class="control-label hidden-phone" for="ciudad">Ciudad</label>
        <div class="controls">
          <input type="text" name="ciudad" class="required" placeholder="Ciudad" value="<?php echo (isset($datos->ciudad) ? $datos->ciudad : ''); ?>">
        </div>
      </div>
       <div class="control-group">
        <label class="control-label hidden-phone" for="estado">Estado</label>
        <div class="controls">
          <input type="text" name="estado" class="required" placeholder="Estado" value="<?php echo (isset($datos->estado) ? $datos->estado : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="rfc">RFC</label>
        <div class="controls">
          <input type="text" maxlength="13" name="rfc" placeholder="RFC" value="<?php echo (isset($datos->rfc) ? $datos->rfc : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="curp">CURP</label>
        <div class="controls">
          <input type="text" name="curp" placeholder="CURP" value="<?php echo (isset($datos->curp) ? $datos->curp : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="telefono">Telefono</label>
        <div class="controls">
          <input type="text" maxlength="10" name="telefono" class="required" placeholder="Telefono" value="<?php echo (isset($datos->telefono) ? $datos->telefono : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="celular">Celular</label>
        <div class="controls">
          <input type="text" maxlength="10" name="celular" placeholder="Celular" value="<?php echo (isset($datos->celular) ? $datos->celular : ''); ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label hidden-phone" for="email">E-mail</label>
        <div class="controls">
          <input type="text" name="email" placeholder="e-mail" value="<?php echo (isset($datos->celular) ? $datos->celular : ''); ?>">
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
    
    $('form').validate({
        rules:{
            razon_social:{
                required: function(element){
                    return $('#tipo option:selected').val() === 'moral';
                },
                minlength: 10
            }
        },
        highlight: function(element, errorClass) {
            $(element).fadeOut(function() {
              $(element).fadeIn();
            });
        }
    });
});
</script>