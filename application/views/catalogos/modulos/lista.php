<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>
<div class="row-fluid">
    <form class="form-horizontal">
        <div class="control-group">
            <label class="control-label hidden-phone" for="id_calle">Calle</label>
            <div class="controls">
                <select id="id_calle" class="span6">
                        <option value="0">Selecciona una calle...</option>
                        <?php foreach ($calles as $r): ?>
                                <option 
                                    value="<?php echo $r->id; ?>"
                                    <?php
                                        if(!empty($calle->id))
                                            echo ($calle->id == $r->id ? 'selected' : '');
                                    ?>
                                >
                                <?php echo $r->nombre.' '.$r->descripcion; ?>
                                </option>
                        <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>
</div>

<div class="row-fluid">
    <div class="span10">
        <?php if(isset($pagination)){ ?>
        <div class="pagination"><?php echo $pagination; ?></div>
        <?php } ?>
    </div>
    <div class="span2">
        <p class="text-right"><?php echo $link_add; ?></p>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        
        <?php if (!empty($calle)) : ?>
	        <div class="data"><?php echo $table; ?></div>
    	<?php endif; ?>
    </div>
</div>

<script type="text/javascript">

$(function () {

	var url = "<?php echo site_url('catalogos/ferias/modulos') . '/'; ?>";
	var id_m = $('#id_calle');

	id_m.change(function () {
		if ($(this).val() > 0) {
            window.location = url + $(this).val();
        }
	});
	
});

</script>
