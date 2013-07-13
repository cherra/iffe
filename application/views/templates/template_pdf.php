<!--
Template para PDFs
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- <script src="<?php echo asset_url(); ?>bootstrap/js/bootstrap.min.js"></script> -->
        <style>
            body{
                font-size: 11px; 
                line-height: 14px;
                color: #000000;
            }
            
            .page-header{
                margin-bottom: 1em;
                padding-bottom: 0.1em;
            }
            
            .cancelado{
                color: gray;
                
            }
            
            @page{
                margin-left: 15mm;
                margin-right: 12mm;
                margin-top: 12mm;
                margin-bottom: 12mm;
                margin-footer: 5mm;
                margin-header: 5mm;
            }
            
        </style>
    </head>
    <body>
        {contenido_vista}
    </body>
</html>
