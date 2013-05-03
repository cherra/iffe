<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo $this->config->item('nombre_proyecto'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- css -------------------------------------------------------------------- -->
  <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo asset_url(); ?>jqueryui/css/flick/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
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
    <script src="<?php echo asset_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<!--    <script src="<?php echo asset_url(); ?>js/globalize.js"></script>
    <script src="<?php echo asset_url(); ?>js/globalize.culture.es-MX.js"></script>
-->
    <script src="<?php echo asset_url(); ?>jqueryui/js/jqueryui.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.ui.datepicker-es.js"></script>
<!--    <script src="<?php echo asset_url(); ?>js/alertas.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.validate.js"></script>
    <script src="<?php echo asset_url(); ?>js/messages_es.js"></script>
-->
    <?php 
      if (isset($js)) {
        foreach ($js as $key => $value) {
          echo '<script src="' . $value . '"></script>'; 
        }
      }
    ?>
    
  <style type="text/css">
      .contenedor-principal {
        padding-top: 20px;
        padding-left: 40px;
        padding-bottom: 40px;
      }
  </style>
  <!-- Fav, touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo asset_url(); ?>bootstrap/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo asset_url(); ?>bootstrap/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo asset_url(); ?>bootstrap/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="<?php echo asset_url(); ?>bootstrap/ico/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="<?php echo asset_url(); ?>bootstrap/ico/favicon.png">
</head>
<body>

<!-- contenido ----------------------------------------------------------------------- -->
<div class="container-fluid contenedor-principal">
  <div class="row-fluid">
    <div class="span12">
      <!-- contenido --------------------------------------------------------------- -->
      {contenido_vista}
    </div>
  </div>
</div>
</body>
</html>