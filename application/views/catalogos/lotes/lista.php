<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
        <?php echo $link_back; ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span9">
        <select id="id_fraccionamiento" class="span6">
                <option value="0">Selecciona un fraccionamiento...</option>
                <?php foreach ($fraccionamientos as $f): ?>
                        <option 
                                value="<?php echo $f->id_fraccionamiento; ?>"
                                <?php
                                        if(!empty($fraccionamiento->id_fraccionamiento))
                                                echo ($fraccionamiento->id_fraccionamiento == $f->id_fraccionamiento ? 'selected' : '');
                                ?>
                        >
                        <?php echo $f->descripcion; ?>
                        </option>
                <?php endforeach; ?>
        </select>
        <select id="id_manzana" class="span6" <?php echo (!isset($fraccionamiento) ? 'disabled' : '') ?>>
                <option value="0">Selecciona una manzana...</option>
                <?php foreach ($manzanas as $m): ?>
                        <option 
                                value="<?php echo $m->id_manzana; ?>"
                                <?php
                                        if(!empty($manzana->id_manzana))
                                                echo ($manzana->id_manzana == $m->id_manzana ? 'selected' : '');
                                ?>
                        >
                        <?php echo $m->descripcion; ?>
                        </option>
                <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <?php echo $link_add; ?>
        <?php if (!empty($manzana)) : ?>
	        <div class="pagination"><?php echo $pagination; ?></div>
	        <div class="data"><?php echo $table; ?></div>
    	<?php endif; ?>
    </div>
</div>

<script type="text/javascript">

$(function () {

	var url = "<?php echo site_url('fraccionamientos/catalogos/lotes') . '/'; ?>";
	var id_f = $('#id_fraccionamiento');
	var id_m = $('#id_manzana');

	id_f.change(function () {
		if ($(this).val() > 0) {
            window.location = url + $(this).val();
        }
        else if($(this).val() <= 0) {
            id_m.children().remove().end().append('<option selected value="0">Selecciona una manzana...</option>') ;
        }

	});

	id_m.change(function () {
		if ($(this).val() > 0) {
            window.location = url + '<?php echo (isset($fraccionamiento->id_fraccionamiento) ? $fraccionamiento->id_fraccionamiento : '0'); ?>/' + $(this).val();
        }
	});
	
});

</script>
