<?php

class Seguridad extends CI_Controller{
    
    /**
    * *****************************************************************
    * template
    * *****************************************************************
    */
    public $layout = 'template_backend';

    /**
    * *****************************************************************
    * titulo para el CRUD
    * *****************************************************************
    */
    private $titulo = 'Seguridad';
    
    function __construct() {
        parent::__construct();
    }
    
    public function permisos_lista( $offset = '0' ){
        
        $this->load->model('preferencias/permiso','p');
        $this->titulo = "Permisos";
        
        // Si se registró la variable flash 'pdf' en la sesión se omite la paginación
        if( $this->session->flashdata('pdf') ){
            $this->layout = 'template_backend_wo_menu';
            $permisos = $this->p->get_paged_list()->result();
        }else{
            $this->config->load("pagination");
            $page_limit = $this->config->item("per_page");
            $permisos = $this->p->get_paged_list($page_limit, $offset)->result();
            // generar paginacion
            $this->load->library('pagination');
            $config['base_url'] = site_url('preferencias/seguridad/permisos_lista/');
            $config['total_rows'] = $this->p->count_all();
            $config['uri_segment'] = 4;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['link_imprimir'] = anchor('preferencias/seguridad/permisos_lista/imprimir','<i class="icon-print"></i>',array('class'=>'btn'));
        }
        
        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Nombre', 'Ruta', 'Menú', 'Icono');
        foreach ($permisos as $permiso) {
                $this->table->add_row(
                        $permiso->nombre, 
                        $permiso->folder.'/'.$permiso->class.'/'.$permiso->method,
                        ($permiso->menu == 1 ? 'Si' : '-'),
                        '<i class="'.$permiso->icon.'"></i>',
                        anchor('preferencias/seguridad/permiso_update/' . $permiso->id_permiso, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                        anchor('preferencias/seguridad/permiso_delete/' . $permiso->id_permiso, '<i class="icon-remove"></i>', array('class' => 'btn btn-small'))
                );
        }
        $data['table'] = $this->table->generate();

        $data['titulo'] = $this->titulo . ' - Lista';

        $uri = $this->uri->segment_array();
        if( in_array('imprimir', $uri) ){ // Si en el url hay 'imprimir' se renderea como pdf
            $this->session->set_flashdata('pdf', true);
            redirect('preferencias/seguridad/permisos_lista'); // Se recarga el método para imprimirlo como PDF
        }else{ // Llamada normal al método
            $this->load->view('preferencias/seguridad/permisos/lista', $data);
        }
    }
    
    /**
	* *****************************************************************
	* Muestra en pantalla el formulario para editar un permiso
	* *****************************************************************
	*/
    public function permiso_update() {

        $this->load->model('preferencias/permiso','p');
        $this->titulo = "Permisos";

        if (!$this->uri->segment(4)) {
                redirect(site_url('preferencias/seguridad/permisos_lista'));
        }
        else {
                $id = $this->uri->segment(4);
        }

        $data['titulo'] = $this->titulo . ' - Modificar';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = anchor('preferencias/seguridad/permisos_lista/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));

        $data['mensaje'] = '';
        $data['action'] = site_url('preferencias/seguridad/permiso_update') . '/' . $id;

        $permiso = $this->p->get_by_id($id)->row();
        $data['permiso'] = $permiso;
        if ($this->input->post() == false) {
            $this->load->view('preferencias/seguridad/permisos/formulario', $data);
        }
        else {
            $permiso = array(
                        'nombre' => $this->input->post('nombre'),
                        'icon' => $this->input->post('icon'),
                        'menu' => $this->input->post('menu')
                        );
            $this->p->update($id, $permiso);
            $data['permiso'] = (object)$permiso;
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
            $this->load->view('preferencias/seguridad/permisos/formulario', $data);
        }

    }
    
    public function permiso_delete( $id ){
        if (empty($id)) {
            redirect(site_url('preferencias/seguridad/permisos_lista/'));
        }
        
        $id = floatval($id);
        
        $this->load->model('preferencias/permiso', 'p');
        $this->p->delete($id);
        redirect(site_url('preferencias/seguridad/permisos_lista/'));
    }
    
    public function roles_lista(){
        
        $this->load->model('preferencias/rol','c');
        $this->titulo = "Roles";
        
        // obtener offset
        $uri_segment = 4;
        $offset = $this->uri->segment($uri_segment);
        
        // obtener datos
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        $roles = $this->c->get_paged_list($page_limit, $offset)->result();

        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url('preferencias/seguridad/roles_lista/');
        $config['total_rows'] = $this->c->count_all();
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Nombre', 'Descripción', '', '', '');
        foreach ($roles as $rol) {
                $this->table->add_row(
                        strtoupper($rol->nombre), 
                        strtoupper($rol->descripcion),
                        anchor('preferencias/seguridad/rol_permisos/' . $rol->id_rol, '<i class="icon-lock"></i>', array('class' => 'btn btn-small')),
                        anchor('preferencias/seguridad/rol_update/' . $rol->id_rol, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                        anchor('preferencias/seguridad/rol_delete/' . $rol->id_rol, '<i class="icon-remove"></i>', array('class' => 'btn btn-small'))
                );
        }
        $data['table'] = $this->table->generate();
        $data['link_add'] = anchor('preferencias/seguridad/rol_add/','<li class="icon-plus"></li> Agregar', array('class' => 'btn'));
        $data['titulo'] = $this->titulo . ' - Lista';

        $this->load->view('preferencias/seguridad/roles/lista', $data);
    }
    
    public function rol_add() {
        $data['titulo'] = 'Roles - Agregar';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = anchor('preferencias/seguridad/roles_lista/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('preferencias/seguridad/rol_add');
        
        if ($this->input->post() == false) {
            $this->load->view('preferencias/seguridad/roles/formulario', $data);
        }
        else {
            $rol = array(
                'nombre' => $this->input->post('nombre', true),
                'descripcion' => $this->input->post('descripcion', true)
            );
            
            $this->load->model('preferencias/rol', 'r');
            $this->r->save($rol);
            
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
            $this->load->view('preferencias/seguridad/roles/formulario', $data);
        }
    }
    
    public function rol_update( $id ) {

        $this->load->model('preferencias/rol','r');
        $this->titulo = "Roles";
        
        if (empty($id)) {
                redirect(site_url('preferencias/seguridad/roles_lista'));
        }

        $data['titulo'] = $this->titulo . ' - Modificar';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = anchor('preferencias/seguridad/roles_lista/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));

        $data['mensaje'] = '';
        $data['action'] = site_url('preferencias/seguridad/rol_update') . '/' . $id;

        $rol = $this->r->get_by_id($id)->row();
        $data['rol'] = $rol;
        if ($this->input->post() == false) {
            $this->load->view('preferencias/seguridad/roles/formulario', $data);
        }
        else {
            $rol = array(
                        'nombre' => $this->input->post('nombre'),
                        'descripcion' => $this->input->post('descripcion')
                        );
            $this->r->update($id, $rol);
            $data['rol'] = (object)$rol;
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
            $this->load->view('preferencias/seguridad/roles/formulario', $data);
        }

    }
    
    public function rol_delete( $id ){
        if (empty($id)) {
            redirect(site_url('preferencias/seguridad/roles_lista/'));
        }
        
        $id = floatval($id);
        
        $this->load->model('preferencias/rol', 'r');
        $this->r->delete($id);
        redirect(site_url('preferencias/seguridad/roles_lista/'));
    }
    
    public function rol_permisos( $id ) {

        $this->load->model('preferencias/rol','r');
        $this->load->model('preferencias/permiso','p');
        $this->titulo = "Roles";
        
        if (empty($id)) {
                redirect(site_url('preferencias/seguridad/roles_lista'));
        }

        $data['titulo'] = $this->titulo . ' - Permisos';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = anchor('preferencias/seguridad/roles_lista/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));

        $data['mensaje'] = '';
        $data['action'] = site_url('preferencias/seguridad/rol_permisos') . '/' . $id;

        $rol = $this->r->get_by_id($id)->row();
        $data['rol'] = $rol;
        
        /* Si llegan datos por POST, se insertan en la base de datos*/
        if ($this->input->post()) {
            $perms = array();
            if($this->input->post('permisos')){
                foreach ($this->input->post('permisos') as $permiso){
                    $perms[] = array(
                        'id_rol' => $id,
                        'id_permiso' => $permiso,
                        'valor' => '1'
                    );
                }
            }
            $this->r->update_permisos($id, $perms);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        
        // Obtener todos los permisos
        $permisos = $this->p->get_all()->result();
        
        // generar tabla con permisos
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Menú','Nombre', 'Ruta', 'Activo');
        foreach ($permisos as $permiso) {
            $this->table->add_row(
                    strtoupper($permiso->folder), 
                    $permiso->nombre, 
                    $permiso->permKey,
                    '<input type="checkbox" name="permisos[]" value="'.$permiso->id_permiso.'" '.($this->r->get_permiso_by_id($permiso->id_permiso, $id)->num_rows() > 0 ? 'checked' : '').'/>'
            );
        }
        $data['table'] = $this->table->generate();
        
        $this->load->view('preferencias/seguridad/roles/permisos', $data);

    }
    
    
    public function usuarios_lista(){
        
        $this->load->model('preferencias/usuario','u');
        $this->titulo = "Usuarios";
        
        // obtener offset
        $uri_segment = 4;
        $offset = $this->uri->segment($uri_segment);
        
        // obtener datos
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        $usuarios = $this->u->get_paged_list($page_limit, $offset)->result();
        
        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url('preferencias/seguridad/usuarios_lista/');
        $config['total_rows'] = $this->u->count_all();
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Nombre', 'Username', 'Activo', '');
        
        $i = 0 + $offset;
        foreach ($usuarios as $usuario) {
                $this->table->add_row(
                        strtoupper($usuario->nombre), 
                        strtoupper($usuario->username),
                        $usuario->activo == 's' ? '<i class="icon-ok"></i>' : '',
                        anchor('preferencias/seguridad/usuario_permisos/' . $usuario->id_usuario, '<i class="icon-lock"></i>', array('class' => 'btn btn-small')),
                        anchor('preferencias/seguridad/usuario_update/' . $usuario->id_usuario, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                        anchor('preferencias/seguridad/usuario_delete/' . $usuario->id_usuario, '<i class="icon-remove"></i>', array('class' => 'btn btn-small'))
                );
        }
        
        $data['table'] = $this->table->generate();
        $data['link_add'] = anchor('preferencias/seguridad/usuario_add','<li class="icon-plus"></li> Agregar', array('class' => 'btn'));
        $data['titulo'] = $this->titulo . ' - Lista';

        $this->load->view('preferencias/seguridad/usuarios/lista', $data);
    }
    
    public function usuario_update() {

        $this->load->model('preferencias/usuario','u');
        $this->titulo = "Usuarios";

        if (!$this->uri->segment(4)) {
                redirect(site_url('preferencias/seguridad/usuarios_lista'));
        }
        else {
                $id = $this->uri->segment(4);
        }

        $data['titulo'] = $this->titulo . ' - Modificar';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = anchor('preferencias/seguridad/usuarios_lista/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));

        $data['mensaje'] = '';
        $data['action'] = site_url('preferencias/seguridad/usuario_update') . '/' . $id;

        $usuario = $this->u->get_by_id($id)->row();
        $data['usuario'] = $usuario;
        if ($this->input->post() == false) {
            $this->load->view('preferencias/seguridad/usuarios/formulario', $data);
        }
        else {
            if(strlen($this->input->post('password')) > 0){
                $usuario = array(
                    'nombre' => $this->input->post('nombre'),
                    'username' => $this->input->post('username'),
                    'password' => sha1($this->input->post('password')),
                    'activo' => $this->input->post('activo')
                );
            }else{
                $usuario = array(
                    'nombre' => $this->input->post('nombre'),
                    'username' => $this->input->post('username'),
                    'activo' => $this->input->post('activo')
                );
            }
            $this->u->update($id, $usuario);
            $data['usuario'] = (object)$usuario;
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
            $this->load->view('preferencias/seguridad/usuarios/formulario', $data);
        }

    }
    
    public function usuario_add() {
        $data['titulo'] = 'Usuarios - Agregar';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = anchor('preferencias/seguridad/usuarios_lista/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('preferencias/seguridad/usuario_add');
        
        if ($this->input->post() == false) {
            $this->load->view('preferencias/seguridad/usuarios/formulario', $data);
        }
        else {
            $usuario = array(
                'nombre' => $this->input->post('nombre', true),
                'username' => $this->input->post('username', true),
                'password' => sha1($this->input->post('password')),
                'activo' => $this->input->post('activo', true)
            );
            
            $this->load->model('preferencias/usuario', 'u');
            $this->u->save($usuario);
            
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
            $this->load->view('preferencias/seguridad/usuarios/formulario', $data);
        }
    }
    
    public function usuario_delete( $id ){
        if (empty($id)) {
            redirect(site_url('preferencias/seguridad/usuarios_lista/'));
        }
        
        $id = floatval($id);
        
        $this->load->model('preferencias/usuario', 'u');
        $this->u->delete($id);
        redirect(site_url('preferencias/seguridad/usuarios_lista/'));
    }
    
    public function usuario_permisos( $id ) {

        $this->load->model('preferencias/usuario','u');
        $this->load->model('preferencias/permiso','p');
        $this->titulo = "Permisos";
        
        if (empty($id)) {
                redirect(site_url('preferencias/seguridad/usuarios_lista'));
        }

        $data['titulo'] = $this->titulo . ' - Permisos';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = anchor('preferencias/seguridad/usuarios_lista/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));

        $data['mensaje'] = '';
        $data['action'] = site_url('preferencias/seguridad/usuario_permisos') . '/' . $id;

        $usuario = $this->u->get_by_id($id)->row();
        $data['usuario'] = $usuario;
        
        /* Si llegan datos por POST, se insertan en la base de datos*/
        if ($this->input->post()) {
            $perms = array();
            if($this->input->post('permisos')){
                foreach ($this->input->post('permisos') as $permiso){
                    $perms[] = array(
                        'id_usuario' => $id,
                        'id_permiso' => $permiso,
                        'valor' => '1'
                    );
                }
            }
            $this->u->update_permisos($id, $perms);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        
        // Obtener todos los permisos
        $permisos = $this->p->get_all()->result();
        
        // generar tabla con permisos
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Menú','Nombre', 'Ruta', 'Activo');
        foreach ($permisos as $permiso) {
            $this->table->add_row(
                    strtoupper($permiso->folder), 
                    $permiso->nombre, 
                    $permiso->permKey,
                    '<input type="checkbox" name="permisos[]" value="'.$permiso->id_permiso.'" '.($this->u->get_permiso_by_id($permiso->id_permiso, $id)->num_rows() > 0 ? 'checked' : '').'/>'
            );
        }
        $data['table'] = $this->table->generate();
        
        $this->load->view('preferencias/seguridad/usuarios/permisos', $data);

    }
}

?>
