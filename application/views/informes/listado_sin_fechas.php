<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>
<!-- La clase formulario se oculta en el template de para PDFs  -->
<div class="row-fluid formulario">
    <div class="span12">
    <?php echo form_open('', array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form')) ?>
        <div class="control-group">
            <label class="control-label hidden-phone" for="filtro">Filtros</label>
            <div class="controls">
              <input type="text" name="filtro" id="filtro" placeholder="Filtros de busqueda" value="<?php if(isset($filtro)) echo $filtro; ?>" >
            </div>
        </div>
    <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    <?php echo form_close(); ?>
    </div>
</div>
<!-- PDF generado  -->
<div class="row-fluid">
    <div class="span12">
        <a id="informe_view" href="<?php echo asset_url().$this->configuracion->get_valor('tmp_path').$reporte; ?>"></a>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#form').submit(function(event){
            $('#loadingModal').modal();
        });
        
        $('#informe_view').media({ width: '100%', height: 600, autoplay: true });
    });
</script>