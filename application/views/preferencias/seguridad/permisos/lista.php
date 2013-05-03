<h3><?php echo $titulo; ?></h3> 
<div class="row-fluid">
  <!-- <?php echo anchor('preferencias/seguridad/permiso_add/','<i class="icon-plus"></i> Agregar', array('class' => 'btn')); ?> -->
<?php
if(!empty($pagination)){
?>
  <div class="span10"><div class="pagination"><?php echo $pagination; ?> </div></div>
<?php
}
if(!empty($link_imprimir)){
?>
  <div class="span2"><div class="visible-desktop" style="margin: 20px 0;"><?php echo $link_imprimir; ?></div></div>
  <?php
}
  ?>
  <div class="span12">
    <div class="data"><?php echo $table; ?></div>
  </div>
</div>