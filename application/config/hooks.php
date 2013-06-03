<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

/*
| -------------------------------------------------------------------------
| Hook para aumentar el metodo 'display_override' de CI
| -------------------------------------------------------------------------
| Con este hook podemos cargar el template principal sin necesidad de
| declarar alguna vista en cada uno de los metodos del controlador.
|
| Ejemplo 1:
| class Welcome extends CI_Controller {
|  
|    public $layout = 'default';
|  
|    public function index()
|    {
|        $this->load->view('welcome_message');
|    }
| }
|
| Ejemplo 2: si se necesita un template diferente para un metodo
| class Welcome extends CI_Controller {
|  
|    public $layout;
|  
|    public function index()
|    {
		 $this->layout = 'default2';
|        $this->load->view('welcome_message');
|    }
| }
|
| nota:
| default es el nombre de la vista template que se quiera utilizar
|
| codigo original:
| http://www.syahzul.com/blogs/item/codeigniter-layout-without-using-additional-library
|
*/

$hook['post_controller_constructor'][] = array(
    'class' => 'acl',
    'function' => 'hasPermission',
    'filename' => 'acl.php',
    'filepath' => 'hooks'
);

$hook['post_controller_constructor'][] = array(
    'class' => 'Periodo_activo',
    'function' => 'index',
    'filename' => 'periodo_activo.php',
    'filepath' => 'hooks'
);

$hook['post_controller'][] = array(
    'class' => 'menu',
    'function' => 'menuOptions',
    'filename' => 'menu.php',
    'filepath' => 'hooks'
);

/*$hook['display_override'] = array(
	'class' => 'Layout',
	'function' => 'index',
	'filename' => 'layout.php',
	'filepath' => 'hooks'
);*/
$hook['post_controller'][] = array(
	'class' => 'Layout',
	'function' => 'index',
	'filename' => 'layout.php',
	'filepath' => 'hooks'
);


/* End of file hooks.php */
/* Location: ./application/config/hooks.php */