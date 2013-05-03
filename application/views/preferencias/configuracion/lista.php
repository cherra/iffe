<div class="row-fluid">
  <h3><?php echo $titulo; ?></h3>
  <?php echo anchor('preferencias/preferencias/configuracion_add/','<i class="icon-plus"></i> Agregar', array('class' => 'btn')); ?>
  <br />
  <div class="span12">
    <div class="pagination"><?php echo $pagination; ?></div>
    <div class="data"><?php echo $table; ?></div>
  </div>
</div>