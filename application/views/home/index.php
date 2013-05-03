<div class="container">
      <h2><?php echo $this->config->item('nombre_proyecto'); ?> - plano</h2>
      <div class="map-viewport">
	<div id="map-1">
        <!--        <img src="<?php echo $plano50; ?>" width="758" height="427" alt="" usemap="#map" class="level" />
		<img src="<?php echo $plano75; ?>" width="1136" height="640" alt="" class="level" />-->
                <img src="<?php echo $plano; ?>" width="1515" height="854" alt="" class="level" usemap="#map" /> 
	</div>
          <div id="selections" style="clear:both;"></div>
	<map name="map">
		<!-- <area title="City name" shape="poly" name="city" coords="55,65,355,295, 300,65" href="#goes" alt="" /> -->
		<!-- <area title="Train station" shape="rect" coords="70,65,120,90" href="#train-station" alt="" /> -->
                <area shape="poly" title="ply" name="redpepper" coords="412,156, 427,161, 429,163, 444,153, 453,155, 457,159, 452,168, 459,174, 455,178, 460,179, 463,193, 460,203, 441,214, 436,217, 458,238, 469,257, 479,267, 478,269, 479,285, 458,309, 436,310, 414,305, 410,323, 397,334, 379,313, 389,316, 401,320, 399,305, 382,300, 371,290, 367,296, 366,298, 338,274, 332,272, 300,239, 316,238, 316,234, 313,230, 328,225, 333,213, 338,196, 333,181, 337,166, 345,145" href="#">

	</map>
          

      </div>
</div>
<div class="container-fluid">
    <div class="row-fluid">
      <div class="span4">
        <h3>Ventas</h3>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
      </div><!--/span-->
      <div class="span4">
        <h3>Bitacora</h3>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
      </div><!--/span-->
      <div class="span4">
        <h3>Garantías</h3>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
      </div><!--/span-->
    </div><!--/row-->
    <div class="row-fluid">
      <div class="span8">
        <h3>Escrituración en tránsito</h3>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
      </div><!--/span-->
      <div class="span4">
        <h3>Título 3</h3>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">Ver detalles &raquo;</a></p>
      </div>
    </div>
</div>
<script>
$(document).ready(function(){
    /*$("#map-1").mapz({
        zoom: true,
        createmaps: true,
        mousewheel: true
    });*/
    
});
</script>