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
     *  Cambia el icono del botón de estado para indicar el estado que tendría
     *  el contrato al darle click.
     */
    var etiqueta_clase = "";
    
    $('#estado').mouseenter(function(){
        var etiqueta = $(this).children('i');
        etiqueta_clase = etiqueta.attr('class');
        if(etiqueta.hasClass('icon-time'))
            etiqueta.removeClass().addClass('icon-ok');
        else if(etiqueta.hasClass('icon-ok'))
            etiqueta.removeClass().addClass('icon-ban-circle');
    });
    
    $('#estado').mouseleave(function(){
        var etiqueta = $(this).children('i');
        etiqueta.removeClass().addClass(etiqueta_clase);
    });
    
    
    /*
     * 
     */
    $('#cancelar').click(function(event){
        var a = confirm("¿Seguro(a) que deseas cancelar el contrato?\nEsta acción no se puede deshacer.");
        if(!a)
            event.preventDefault();
    });
    
    $('#autorizar').click(function(event){
        var a = confirm("¿Seguro(a) que deseas autorizar el contrato?");
        if(!a)
            event.preventDefault();
    });
});
</script>