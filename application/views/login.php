<style type="text/css">

  .form-signin {
    padding-top: 40px;
    padding-bottom: 40px;
    max-width: 300px;
    padding: 40px 29px 40px;
    margin: 0 auto 20px;
    background-color: #fff;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
       -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
  }

  .form-signin .form-signin-heading,
  .form-signin .checkbox {
    margin-bottom: 10px;
  }

  .form-signin input[type="text"],
  .form-signin input[type="password"] {
    font-size: 16px;
    height: auto;
    margin-bottom: 15px;
    padding: 7px 9px;
  }

</style>

<div class="container">
  <div class="row">
    <div class="offset4 span4">
        <?php echo form_open('login/process', array('class' => 'form-signin')); ?>
          <h2 class="form-signin-heading">login</h2>
          <input type="text" name="username" id="usuario" class="input-block-level small" placeholder="Nombre de usuario">
          <input type="password" name="password" id="contrasena" class="input-block-level small" placeholder="Contraseña">
          <button id="ingresar" class="btn btn-large btn-primary" type="submit">Iniciar sesión</button>
          <input type="hidden" id="base-url" value="<?php echo base_url(); ?>" />
        <?php echo form_close(); ?>
    </div>
  </div>  
</div>
<div style="text-align: center;"><?php echo $msg; ?></div>

<script> 
    $(document).ready(function(){
        $('#usuario').focus();
    });
    
</script>