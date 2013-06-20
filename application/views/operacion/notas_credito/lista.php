<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>
<div class="row-fluid">
    <?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form')) ?>
        <div class="control-group">
            <label class="control-label hidden-phone" for="filtro">Filtros</label>
            <div class="controls">
              <input type="text" name="filtro" id="filtro" placeholder="Filtros de busqueda" value="<?php if(isset($filtro)) echo $filtro; ?>" >
              <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>
<div class="row-fluid">
    <div class="span10">
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
    <div class="span2">
        <p class="text-right"><?php echo $link_add; ?></p>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="data"><?php echo $table; ?></div>
    </div>
</div>
<!-- <div class="row-fluid">
  <div class="span6 offset3">
    <?php echo $mensaje ?>
  </div>
</div>
-->
<script>
$(document).ready(function(){
    /*
     * 
     */
    $('td').on('click','#cancelar', function(event){
        var a = confirm("¿Seguro(a) que deseas cancelar la nota de crédito?\nEsta acción no se puede deshacer.");
        if(!a)
            event.preventDefault();
    });
    
    $('td').on('click','#revisar', function(event){
        var a = confirm("¿Seguro(a) que deseas marcar como revisada la nota de crédito?");
        if(!a)
            event.preventDefault();
    });
    
    $('td').on('click','#autorizar', function(event){
        var a = confirm("¿Seguro(a) que deseas autorizar la nota de crédito?");
        if(!a)
            event.preventDefault();
    });
});
</script>