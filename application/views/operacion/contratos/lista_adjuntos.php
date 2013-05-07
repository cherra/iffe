<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
        <?php echo $link_back; ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <select id="id_contrato" class="span6">
            <option value="0">Selecciona un contrato...</option>
            <?php
            foreach($contratos as $c){ ?>
                <option value="<?php echo $c->id_contrato; ?>" <?php if(!empty($contrato->id_contrato)) echo ($contrato->id_contrato == $c->id_contrato ? 'selected' : ''); ?>><?php echo $c->vendedor.' - '.$c->cliente; ?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-condensed">
            <tr class="info">
                <td><strong>Fraccionamiento</strong></td>
                <td><strong>Manzana</strong></td>
                <td><strong>Lote</strong></td>
                <td class="hidden-phone"><strong>Cliente</strong></td>
                <td class="hidden-phone"><strong>Fecha</strong></td>
            </tr>
            <?php
            if(!empty($contrato)){
            ?>
            <tr>
                <td><?php echo $contrato->fraccionamiento; ?></td>
                <td><?php echo $contrato->manzana; ?></td>
                <td><?php echo $contrato->lote; ?></td>
                <td class="hidden-phone"><?php echo $contrato->cliente; ?></td>
                <td class="hidden-phone"><?php echo $contrato->fecha; ?></td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>

<div class="row-fluid">
  <div class="span12">
    <?php if(!empty($contrato)){
        echo $link_add; ?>
        <div class="pagination"><?php echo $pagination; ?></div>
        <div class="data"><?php echo $table; ?></div>
        <?php
    }
        ?>
  </div>
</div>

<!-- Para ver los archivos adjuntos -->
<div class="row-fluid">
    <div class="span11">
        <a id="adjunto_view" id href="#"></a>
    </div>
</div>

<script>

$(document).ready(function(){
    var url = "<?php echo site_url(); ?>/ventas/ventas/contratos_adjuntos";
   
    $('#id_contrato').on('change',function(){
       if($(this).val() > 0)
           $(location).attr('href',url+'/'+$(this).val());
    });
    
    $('a[preview_link]').click( function(event) {
        event.preventDefault();
        $('#adjunto_view').attr('href',$(this).attr('path'));
        $('#adjunto_view').media({ width: '100%', autoplay: true });
    });
   
});

</script>