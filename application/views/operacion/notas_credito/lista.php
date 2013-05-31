<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
        <?php echo $add_link; ?>
    </div>
</div>
<div class="row-fluid">
  <div class="span12">
    <div class="pagination"><?php echo $pagination; ?></div>
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