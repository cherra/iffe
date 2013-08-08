<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>
<div class="row-fluid">
    <?php echo form_open('preferencias/utilerias/respaldo'); ?>
        <fieldset>
            <label>Haz click en el botón para descargar un respaldo de la base de datos.</label>
            <input type="hidden" name="respaldo" value="1" />
            <button type="submit" class="btn btn-success" >Respaldo</button>
        </fieldset>
    <?php echo form_close(); ?>
</div>