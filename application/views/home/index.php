<div class="container-fluid">
  <div class="row-fluid">
    <div class="hero-unit">
      <h2><?php echo $this->config->item('nombre_proyecto'); ?> - dashboard</h2>
      <p>
        Natoque enim penatibus aliquam phasellus integer nisi mid urna magnis in phasellus turpis penatibus, nascetur? Sed vut velit, cras elementum sit diam sagittis augue urna! 
        In magna nec, dolor pulvinar a velit odio odio, dapibus hac arcu augue, turpis? 
      </p>
      <p style="text-align: center;"><img src="<?php echo $grafico_barras; ?>" /></p>
    </div>
    <div class="row-fluid">
      <div class="span4">
        <h3>Ventas</h3>
        <p><img src="<?php echo $grafico_lineas; ?>" /></p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
      </div><!--/span-->
      <div class="span4">
        <h3>Bitacora</h3>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
      </div><!--/span-->
      <div class="span4">
        <h3>Garantías</h3>
        <p><img src="<?php echo $grafico_pastel_3d; ?>" /></p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
      </div><!--/span-->
    </div><!--/row-->
    <div class="row-fluid">
      <div class="span8">
        <h3>Escrituración en tránsito</h3>
        <p><img src="<?php echo $grafico_gantt; ?>" /></p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
      </div><!--/span-->
      <div class="span4">
        <h3>Título 3</h3>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
    </div>
  </div>
</div>