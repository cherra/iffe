<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo $this->config->item('nombre_proyecto'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <!-- css -------------------------------------------------------------------- -->
  <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet">
  <style type="text/css">
      body{
          padding-top: 50px;
      }
      
       @media (max-width: 980px) {
        .pagination{
            margin: 5px 0;
        }
      }
      
  </style>
  <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
  <link href="<?php echo asset_url(); ?>jqueryui/css/flick/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
  <?php 
    if (isset($css)) {
      foreach ($css as $key => $value) {
        echo '<link href="' . $value . '" rel="stylesheet">'; 
      }
    }
  ?> 
  
  <style>
      

      .sidebar-nav {
        padding: 9px 0;
      }
      
      .page-header{
        margin: 10px 0 10px;
        padding-bottom: 5px;
      }

      .pagination{
        margin: 5px 0;
      }

      .navbar-fixed-top{
        margin-bottom: 10px;
      }

      /* Tablets y mobiles*/
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
        
        .sidebar-nav{
            margin-bottom: 5px;
        }
      }
  </style>
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="<?php echo asset_url(); ?>bootstrap/js/html5shiv.js"></script>
  <![endif]-->
  
  <!-- js ---------------------------------------------------------------------- -->
    <script src="<?php echo asset_url(); ?>js/jquery.js"></script>
    <script src="<?php echo asset_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/globalize.js"></script>
    <script src="<?php echo asset_url(); ?>js/globalize.culture.es-MX.js"></script>
    <script src="<?php echo asset_url(); ?>jqueryui/js/jqueryui.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.ui.datepicker-es.js"></script>
    <script src="<?php echo asset_url(); ?>js/alertas.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.validate.js"></script>
    <script src="<?php echo asset_url(); ?>js/messages_es.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.media.js"></script>
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
    <div class="container-fluid">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
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
            <li <?php 
            // Si el primer segmento del URI es igual al folder quiere decir que es la opción seleccionada
            // y se marca como activa para resaltarla
            if( $this->uri->segment(1) == $folder->folder) 
                echo 'class="active"'; 
            ?>><?php 
            echo anchor($folder->folder.'/'.$folder->folder, strtoupper($folder->folder), 'class="navbar-link"'); ?></li>
            <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- contenido ----------------------------------------------------------------------- -->
<div class="container-fluid contenedor-principal">
  <div class="row-fluid">
      <!-- Menú lateral para tablets y escritorio -->
    <div class="span3 hidden-phone">
      <div class="well sidebar-nav">
        <ul class="nav nav-list">
            <?php
            $clase = '';
            $metodos = $this->session->userdata('submenu');
            foreach ( $metodos as $metodo ){
                if($clase != $metodo->class){
                    $clase = $metodo->class;
            ?>
                    <li class="nav-header"><?php echo $metodo->class; ?></li>
            <?php
                }
                // Link para el menú
                $link = $metodo->folder.'/'.$metodo->class.'/'.$metodo->method;
            ?>
                    <li <?php 
                    // Si el link es igual al URI quiere decir que es la opción seleccionada
                    // y se marca como activa para resaltarla
                    if( strpos(current_url(), $metodo->folder.'/'.$metodo->class.'/'.$metodo->method) ) 
                        echo 'class="active"'; 
                    ?>><?php echo anchor($link, '<i class="'.$metodo->icon.'"></i> '.$metodo->nombre) ?></li>
            <?php
            }
            ?>
        </ul>
      </div>
    </div>
    <div class="span9">
      <!-- contenido --------------------------------------------------------------- -->
      {contenido_vista}
    </div>
      <!-- Menú inferior para mobiles -->
    <div class="span3 visible-phone">
        <button type="button" class="btn btn-block btn-info" data-toggle="collapse" data-target="#collapse_sidemenu"><i class="icon-plus icon-white"></i> Menú de opciones</button>
        <div id="collapse_sidemenu" class="collapse">
            <div class="well sidebar-nav">
              <!-- menu lateral --------------------------------------------------------------- -->
              <ul class="nav nav-list">
                  <?php
                  foreach ( $metodos as $metodo ){
                      if($clase != $metodo->class){
                          $clase = $metodo->class;
                  ?>
                          <li class="nav-header"><?php echo $metodo->class; ?></li>
                  <?php
                      }
                      // Link para el menú
                      $link = $metodo->folder.'/'.$metodo->class.'/'.$metodo->method;
                  ?>
                          <li <?php 
                          // Si el link es igual al URI quiere decir que es la opción seleccionada
                          // y se marca como activa para resaltarla
                          if( strpos(current_url(), $link) ) 
                              echo 'class="active"'; 
                          ?>><?php echo anchor($link, '<i class="'.$metodo->icon.'"></i> '.$metodo->nombre) ?></li>
                  <?php
                  }
                  ?>
              </ul>
            </div>
        </div>
        <div></div>
    </div>
  </div>
</div>

<div class="navbar navbar-inverse navbar-fixed-bottom visible-phone">
  <div class="navbar-inner">
        <p class="navbar-text">
          <?php echo anchor('login/do_logout','<i class="icon-user icon-white"></i> Salir','class="navbar-link pull-right"'); ?>
        </p>
  </div>
</div>

<!-- alertas y loader -------------------------------------------------------------- -->
<div id="alerta-normal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body"><div class="alert"><h5 class="etiqueta">Advertencia</h5><span class="mensaje"></span></div></div>
  <div class="modal-footer"><a href="#" id="alerta-boton" class="btn">Aceptar</a></div>
</div>
<div id="alerta-error" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body"><div class="alert alert-error"><h5 class="etiqueta">Error</h5><span class="mensaje"></span></div></div>
  <div class="modal-footer"><a href="#" id="alerta-error-boton" class="btn btn-danger">Aceptar</a></div>
</div>
<div id="loader" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body" style="text-align: center;"><span class="mensaje">cargando</span><br /><img src="<?php echo asset_url(); ?>img/loader.gif" /></div>
</div>

<script>
    $(document).ready(function(){
        
        //$('input[type="text"]').attr('autocomplete', 'off');
        
        $('form').validate({
            rules: {
                confirmar_password: {
                    equalTo: "#password"
                }
            },
            highlight: function(element, errorClass) {
                $(element).fadeOut(function() {
                  $(element).fadeIn();
                });
            }
        });
        
        // Widget para los input donde se debe ingresar una hora (ej. 14:00)
        $.widget( "ui.timespinner", $.ui.spinner, {
            options: {
                // seconds
                step: 600 * 3000,
                // hours
                page: 60
            },

            _parse: function( value ) {
                if ( typeof value === "string" ) {
                    // already a timestamp
                    if ( Number( value ) == value ) {
                        return Number( value );
                    }
                    return +Globalize.parseDate( value );
                }
                return value;
            },

            _format: function( value ) {
                return Globalize.format( new Date(value), "t" );
            }
        });
        
        Globalize.culture( 'es-MX' );
        // Obtiene la fecha actual
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var hour = d.getHours();
        var minutes = d.getMinutes();
        
        // Campos de tipo fecha
        var fecha = d.getFullYear() + '-' +
            (month<10 ? '0' : '') + month + '-' +
            (day<10 ? '0' : '') + day;
    
        $('.fecha').datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        });
        $('.fecha').each(function(){
            if($(this).val() === "")
                $(this).datepicker("setDate", fecha); 
        });
        
        // Campos de tipo hora
        var hora = (hour<10 ? '0' : '') + hour + ':' +
            (minutes<10 ? '0' : '') + minutes;
        
        // Los input con la clase "hora" se utilizan para seleccionar la hora
        $('.hora').timespinner();
        $('.hora').val(hora);
    });
</script>

</body>
</html>