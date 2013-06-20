<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clientes
 *
 * @author cherra
 */
class Clientes extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function lista($offset = 0) {
    	
    	$this->load->model('cliente', 'f');
    	$this->config->load("pagination");
    	
    	$page_limit = $this->config->item("per_page");
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
    	$clientes = $this->f->get_paged_list($page_limit, $offset, $filtro)->result();
    	//echo $this->db->last_query();
        //die();
    	// generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url('catalogos/clientes/lista');
    	$config['total_rows'] = $this->f->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Razón social','Nombre', array('data' => 'Telefono','class' => 'hidden-phone'),array('data' => 'Celular', 'class' => 'hidden-phone'), '');
    	foreach ($clientes as $cliente) {
    		$this->table->add_row(
                    $cliente->razon_social,
                    $cliente->apellido_paterno.' '.$cliente->apellido_materno.' '.$cliente->nombre,
                    array('data' => $cliente->telefono, 'class' => 'hidden-phone'),
                    array('data' => $cliente->celular, 'class' => 'hidden-phone'),
                    anchor('catalogos/clientes/update/' . $cliente->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                    array('data' => anchor('catalogos/clientes/delete/' . $cliente->id, '<i class="icon-remove"></i>', array('class' => 'btn btn-small')), 'class' => 'hidden-phone')
    		);
    	}
    	$data['table'] = $this->table->generate();
    	$data['titulo'] = 'Clientes <small>Lista</small>';
    	$data['link_add'] = anchor('catalogos/clientes/add','<i class="icon-plus icon-white"></i> Agregar', array('class' => 'btn btn-inverse'));
    	$data['action'] = 'catalogos/clientes/lista';
    	$this->load->view('catalogos/clientes/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Clientes - Agregar
     * -------------------------------------------------------------------------
     * @author: bravoteam
     *
     */
    public function add() {
    	$this->load->model('cliente', 'f');
        $this->load->model('giro', 'g');
        $this->load->model('concesion', 'c');
        
        $data['giros'] = $this->g->get_all()->result();
        $data['concesiones'] = $this->c->get_all()->result();
    
    	$data['js'] = array(asset_url() . 'js/jquery.validation.js');
    	$data['titulo'] = 'Clientes <small>Alta</small>';
    	$data['link_back'] = anchor('catalogos/clientes/lista','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
    
    	$data['mensaje'] = '';
    	$data['action'] = site_url('catalogos/clientes/add');
    	if ( ($cliente = $this->input->post()) ) {
    		$this->f->save($cliente);
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
    	} 
        $this->load->view('catalogos/clientes/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Clientes - Modificar
     * -------------------------------------------------------------------------
     * @author: bravoteam
     *
     * @param int $id
     */
    public function update($id = null) {
    	if (empty($id)) {
    		redirect(site_url('catalogos/clientes/lista'));
    	}
    	
        $this->load->model('giro', 'g');
        $this->load->model('concesion', 'c');
        $this->load->model('cliente', 'f');
        
        $cliente = $this->f->get_by_id($id)->row();
    	$data['datos'] = $cliente;
        $data['giros'] = $this->g->get_all()->result();
        $data['concesiones'] = $this->c->get_all()->result();
        
    	if ( ($cliente = $this->input->post()) ) {
    		$this->f->update($id, $cliente);
    		$data['datos'] = (object)$cliente;
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
    	}
        $data['titulo'] = 'Clientes <small>Modificar</small>';
    	$data['link_back'] = anchor('catalogos/clientes/lista','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
    	$data['mensaje'] = '';
    	$data['action'] = site_url('catalogos/clientes/update') . '/' . $id;
        $this->load->view('catalogos/clientes/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Clientes - Borrar
     * -------------------------------------------------------------------------
     * @author: bravoteam
     *
     * @param int $id
     */
    public function delete($id) {
    	if (!isset($id)) {
    		redirect(site_url('catalogos/clientes/lista'));
    	}
    	$this->load->model('cliente', 'f');
    	$this->f->delete($id);
    	redirect(site_url('catalogos/clientes/lista'));
    }

    /**
     * -------------------------------------------------------------------------
     * autocompletar service
     * -------------------------------------------------------------------------
     * 
     */
    public function autocompletar() {
        if($this->input->is_ajax_request()){
            if (($query = $this->input->post('q', true))){
                $this->load->model('cliente', 'c');
                if ( ($clientes = $this->c->get_by_query($query)) ) {
                    echo json_encode($clientes);
                }
                else {
                    echo json_encode(false);    
                }
            }
            else {
                echo json_encode(false);
            }
        }
    }
    
    /*
     * ************************************************************
     * GIROS
     * ************************************************************
     */
    
    public function giros_lista($offset = 0) {
    	
    	$this->load->model('giro', 'f');
    	$this->config->load("pagination");
    	
    	$page_limit = $this->config->item("per_page");
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $data['action'] = 'catalogos/clientes/giros_lista';
        
    	$registros = $this->f->get_paged_list($page_limit, $offset, $filtro)->result();
    	
    	// generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url('catalogos/clientes/giros_lista');
    	$config['total_rows'] = $this->f->count_all( $filtro );
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', array('data' => 'Descripción', 'class' => 'hidden-phone'), '');
    	foreach ($registros as $registro) {
    		$this->table->add_row(
                    $registro->nombre,
                    array('data' => $registro->descripcion, 'class' => 'hidden-phone'),
                    anchor('catalogos/clientes/giros_update/' . $registro->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                    array('data' => anchor('catalogos/clientes/giros_delete/' . $registro->id, '<i class="icon-remove"></i>', array('class' => 'btn btn-small')), 'class' => 'hidden-phone')
    		);
    	}
    	$data['table'] = $this->table->generate();
    	$data['titulo'] = 'Giros <small>Lista</small>';
    	$data['link_add'] = anchor('catalogos/clientes/giros_add','<i class="icon-plus icon-white"></i> Agregar', array('class' => 'btn btn-inverse'));
    	
    	$this->load->view('catalogos/giros/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Clientes - Agregar
     * -------------------------------------------------------------------------
     * @author: bravoteam
     *
     */
    public function giros_add() {
    	$this->load->model('giro', 'f');
    
    	$data['titulo'] = 'Giros <small>Alta</small>';
    	$data['link_back'] = anchor('catalogos/clientes/giros_lista','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
    
    	$data['mensaje'] = '';
    	$data['action'] = site_url('catalogos/clientes/giros_add');
    	if ( ($datos = $this->input->post()) ) {
    		$this->f->save($datos);
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro exitoso</div>';
    	} 
        $this->load->view('catalogos/giros/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Clientes - Modificar
     * -------------------------------------------------------------------------
     * @author: bravoteam
     *
     * @param int $id
     */
    public function giros_update($id = null) {
    	if (empty($id)) {
    		redirect(site_url('catalogos/clientes/giros_lista'));
    	}
    	
    	$data['titulo'] = 'Giros <small>Modificar</small>';
    	$data['link_back'] = anchor('catalogos/clientes/giros_lista','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
    	$data['mensaje'] = '';
    	$data['action'] = site_url('catalogos/clientes/giros_update') . '/' . $id;
    	 
    	$this->load->model('giro', 'f');
    	$datos = $this->f->get_by_id($id)->row();
    	$data['datos'] = $datos;
    	if ( ($datos = $this->input->post()) ) {
    		$this->f->update($id, $datos);
    		$data['datos'] = (object)$datos;
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
    	}
        $this->load->view('catalogos/giros/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Clientes - Borrar
     * -------------------------------------------------------------------------
     * @author: bravoteam
     *
     * @param int $id
     */
    public function giros_delete($id) {
    	if (!isset($id)) {
    		redirect(site_url('catalogos/clientes/giros_lista'));
    	}
    	$this->load->model('giro', 'f');
    	$this->f->delete($id);
    	redirect(site_url('catalogos/clientes/giros_lista'));
    }
    
    
    /*
     * ************************************************************
     * CONCESIONES
     * ************************************************************
     */
    
    public function concesiones_lista($offset = 0) {
    	
    	$this->load->model('concesion', 'f');
    	$this->config->load("pagination");
    	
    	$page_limit = $this->config->item("per_page");
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $data['action'] = 'catalogos/clientes/concesiones_lista';
        
    	$registros = $this->f->get_paged_list($page_limit, $offset, $filtro)->result();
    	
    	// generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url('catalogos/clientes/concesiones_lista');
    	$config['total_rows'] = $this->f->count_all( $filtro );
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', array('data' => 'Descripción', 'class' => 'hidden-phone'), '');
    	foreach ($registros as $registro) {
    		$this->table->add_row(
                    $registro->nombre,
                    array('data' => $registro->descripcion, 'class' => 'hidden-phone'),
                    anchor('catalogos/clientes/concesiones_update/' . $registro->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                    array('data' => anchor('catalogos/clientes/concesiones_delete/' . $registro->id, '<i class="icon-remove"></i>', array('class' => 'btn btn-small')), 'class' => 'hidden-phone')
    		);
    	}
    	$data['table'] = $this->table->generate();
    	$data['titulo'] = 'Concesiones <small>Lista</small>';
    	$data['link_add'] = anchor('catalogos/clientes/concesiones_add','<i class="icon-plus icon-white"></i> Agregar', array('class' => 'btn btn-inverse'));
    	
    	$this->load->view('catalogos/concesiones/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Agregar
     * -------------------------------------------------------------------------
     *
     */
    public function concesiones_add() {
    	$this->load->model('concesion', 'f');
    
    	$data['titulo'] = 'Concesiones <small>Alta</small>';
    	$data['link_back'] = anchor('catalogos/clientes/concesiones_lista','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
    
    	$data['mensaje'] = '';
    	$data['action'] = site_url('catalogos/clientes/concesiones_add');
    	if ( ($datos = $this->input->post()) ) {
    		$this->f->save($datos);
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro exitoso</div>';
    	} 
        $this->load->view('catalogos/concesiones/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Modificar
     * -------------------------------------------------------------------------
     *
     * @param int $id
     */
    public function concesiones_update($id = null) {
    	if (empty($id)) {
    		redirect(site_url('catalogos/clientes/concesiones_lista'));
    	}
    	
    	$data['titulo'] = 'Concesiones <small>Modificar</small>';
    	$data['link_back'] = anchor('catalogos/clientes/concesiones_lista','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
    	$data['mensaje'] = '';
    	$data['action'] = site_url('catalogos/clientes/concesiones_update') . '/' . $id;
    	 
    	$this->load->model('concesion', 'f');
    	$datos = $this->f->get_by_id($id)->row();
    	$data['datos'] = $datos;
    	if ( ($datos = $this->input->post()) ) {
    		$this->f->update($id, $datos);
    		$data['datos'] = (object)$datos;
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
    	}
        $this->load->view('catalogos/concesiones/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Borrar
     * -------------------------------------------------------------------------
     *
     * @param int $id
     */
    public function concesiones_delete($id) {
    	if (!isset($id)) {
    		redirect(site_url('catalogos/clientes/concesiones_lista'));
    	}
    	$this->load->model('concesion', 'f');
    	$this->f->delete($id);
    	redirect(site_url('catalogos/clientes/concesiones_lista'));
    }
}

?>
