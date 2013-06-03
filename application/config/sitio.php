<?php

/*
|--------------------------------------------------------------------------
| Nombre del proyecto
|--------------------------------------------------------------------------
|
*/
$config['nombre_proyecto'] = 'iffe';

/*
|--------------------------------------------------------------------------
| Variable Super Usuario
|--------------------------------------------------------------------------
| Variable para ignorar el modulo de privilegios de usuario
|
*/
$config['developer_mode'] = 0;

/*
|--------------------------------------------------------------------------
| Fechas en español
|--------------------------------------------------------------------------
|
*/
$config['dias'] = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
$config['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

/*
|--------------------------------------------------------------------------
| Assets path
|--------------------------------------------------------------------------
|
| Ruta logica de los archivos que se utilizan en el lado del cliente, y se
| utiliza para el helper asset_url(), helpers/path_helper.php 
|
*/
$config['asset_path'] = 'assets/';
$config['upload_path'] = 'assets/adjuntos/';
$config['contratos_adjuntos_path'] = 'assets/adjuntos/contratos/';
$config['pasos_adjuntos_path'] = 'assets/adjuntos/pasos/';
$config['modelos_adjuntos_path'] = 'assets/adjuntos/modelos/';

/*
|--------------------------------------------------------------------------
| Estilo CSS el HTML Tag <table>
|--------------------------------------------------------------------------
|
| Definicion de las clases CSS de Bootstrap para las tablas
|
*/
$config['tabla_css'] = 'table table-condensed table-striped';

/*
|--------------------------------------------------------------------------
| Configuración para los gráficos
|--------------------------------------------------------------------------
|
|
*/
$config['graph_dir'] = 'tmp/';
$config['graph_theme'] = 'UniversalTheme'; // Temas ubicados en libraries/jpgraph/themes

?>