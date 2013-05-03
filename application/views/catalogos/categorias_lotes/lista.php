<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
        <?php echo $link_back; ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <select id="id_fraccionamiento">
            <option value="0">Selecciona un fraccionamiento...</option>
            <?php
            foreach($fraccionamientos as $f){ ?>
                <option value="<?php echo $f->id_fraccionamiento; ?>" <?php if(!empty($fraccionamiento->id_fraccionamiento)) echo ($fraccionamiento->id_fraccionamiento == $f->id_fraccionamiento ? 'selected' : ''); ?>><?php echo $f->descripcion; ?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>

<div class="row-fluid">
  <div class="span12">
    <?php if(!empty($fraccionamiento)){
        echo $link_add; ?>
        <div class="pagination"><?php echo $pagination; ?></div>
        <div class="data"><?php echo $table; ?></div>
        <?php
    }
        ?>
  </div>
</div>

<script>

$(document).ready(function(){
    var url = "<?php echo site_url(); ?>/fraccionamientos/catalogos/categorias_lotes";
   
    $('#id_fraccionamiento').on('change',function(){
       if($(this).val() > 0)
           $(location).attr('href',url+'/'+$(this).val());
    });
   
});

</script>