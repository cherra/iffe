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
    $('#estado').click(function(event){
        var etiqueta = $(this).children('i');
        if(etiqueta.hasClass('icon-ban-circle')){
            var a = confirm("¿Seguro(a) que deseas cancelar el contrato?\nEsta acción no se puede deshacer");
        }else if(etiqueta.hasClass('icon-ok')){
            var a = confirm("¿Autorizar contrato?");
        }
        if(!a)
            event.preventDefault();
    });
});
</script>