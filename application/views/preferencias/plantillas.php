<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>

<div class="row-fluid">
  <div class="span12">
    <form class="form-horizontal" name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
        <div class="control-group">
                <textarea name="plantilla" id="plantilla" class="required" rows="20"><?php echo (isset($plantilla) ? $plantilla : ''); ?></textarea>
        </div>
        <div class="control-group">
                <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
        </div>
    </form>
  </div>
  <div class="row-fluid">
    <div class="span12">
        <?php echo $mensaje ?>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo asset_url(); ?>tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        /*tinymce.init({
            selector: "textarea",
            language: "es",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            toolbar2: "print preview media | forecolor backcolor emoticons"
        });*/
        tinymce.init({
            selector: "textarea",
            language: "es",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime nonbreaking save table contextmenu directionality",
                "template paste"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | print preview"
        });
    });

</script>
