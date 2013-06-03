<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo $this->config->item('nombre_proyecto'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <!-- css -------------------------------------------------------------------- -->
  <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet">
  <style type="text/css">
      .contenedor-principal {
        padding-top: 50px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        .contenedor-principal {
          padding-top: 0px;
          padding-bottom: 10px;
        }
          
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
        
        .page-header{
            margin: 10px 0 10px;
            padding-bottom: 0;
        }
        
        .pagination{
            margin: 5px 0;
        }
        
        .navbar-fixed-top{
            margin-bottom: 10px;
        }
      }
    </style>
  <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
  <?php 
    if (isset($css)) {
      foreach ($css as $key => $value) {
        echo '<link href="' . $value . '" rel="stylesheet">'; 
      }
    }
  ?>
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="<?php echo asset_url(); ?>bootstrap/js/html5shiv.js"></script>
  <![endif]-->
  
  <!-- js ---------------------------------------------------------------------- -->
    <script src="<?php echo asset_url(); ?>js/jquery.js"></script>
    <script src="<?php echo asset_url(); ?>jqueryui/js/jqueryui.js"></script>
    <script src="<?php echo asset_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/alertas.js"></script>
    <?php 
      if (isset($js)) {
        foreach ($js as $key => $value) {
          echo '<script src="' . $value . '"></script>'; 
        }
      }
    ?>
  <!-- Fav, touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo asset_url(); ?>bootstrap/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo asset_url(); ?>bootstrap/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo asset_url(); ?>bootstrap/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="<?php echo asset_url(); ?>bootstrap/ico/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="<?php echo asset_url(); ?>bootstrap/ico/favicon.png">
</head>
<body>

<!-- menu-top ---------------------------------------------------------------- -->
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <?php 
      // Link para ir al home
      echo anchor(site_url(), $this->config->item('nombre_proyecto'), 'class="brand"'); 
      $periodo = $this->session->userdata('periodo');
      ?>
      <div class="nav-collapse collapse">
        <p class="navbar-text pull-right hidden-phone">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="icon-user icon-white"></i> <?php echo $this->session->userdata('nombre'); ?> <?php echo anchor('login/do_logout','(Salir)','class="navbar-link"'); ?>
        </p>
        <p class="navbar-text pull-right hidden-phone">
              <strong><?php if(!empty($periodo)) echo $periodo->nombre; else echo "¡No hay período activo!"; ?></strong>
        </p>
        <ul class="nav">
            <?php
            // Se obtienen los folders de los métodos para mostrarlos en la barra superior.
            $folders = $this->session->userdata('folders');
            foreach($folders as $folder){ ?>
            <li><?php 
            // Temporalmente se pone uri_string() para redireccionar a donde mismo
            echo anchor($folder->folder.'/'.$folder->folder, strtoupper($folder->folder), 'class="navbar-link"'); ?></li>
            <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- contenido ---------------------------------------------------------------------- -->
{contenido_vista}

<div class="navbar navbar-inverse navbar-fixed-bottom visible-phone">
  <div class="navbar-inner">
        <p class="navbar-text">
          <?php echo anchor('login/do_logout','<i class="icon-user icon-white"></i> Salir','class="navbar-link pull-right"'); ?>
        </p>
  </div>
</div>

<!-- alertas y loader ---------------------------------------------------------------------- -->
<div id="alerta-normal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body"><div class="alert"><h5 class="etiqueta">Advertencia</h5><span class="mensaje"></span></div></div>
  <div class="modal-footer"><a href="#" class="btn">Aceptar</a></div>
</div>
<div id="alerta-error" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body"><div class="alert alert-error"><h5 class="etiqueta">Error</h5><span class="mensaje"></span></div></div>
  <div class="modal-footer"><a href="#" class="btn btn-danger">Aceptar</a></div>
</div>
<div id="loader" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body" style="text-align: center;"><span class="mensaje">cargando</span><br /><img src="<?php echo asset_url(); ?>img/loader.gif" /></div>
</div>

</body>
</html>