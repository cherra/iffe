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
    
    public function clientes($offset = 0) {
    	
    	$this->load->model('ventas/cliente', 'f');
    	$this->config->load("pagination");
    	
    	$page_limit = $this->config->item("per_page");
    	$clientes = $this->f->get_paged_list($page_limit, $offset)->result();
    	
    	// generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url('ventas/catalogos/clientes');
    	$config['total_rows'] = $this->f->count_all();
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', 'Apellido Paterno',array('data' => 'Apellido Materno', 'class' => 'hidden-phone'), array('data' => 'Telefono','class' => 'hidden-phone'),array('data' => 'Celular', 'class' => 'hidden-phone'), '');
    	foreach ($clientes as $cliente) {
    		$this->table->add_row(
                    $cliente->nombre,
                    $cliente->apellido_paterno,
                    array('data' => $cliente->apellido_materno, 'class' => 'hidden-phone'),
                    array('data' => $cliente->telefono, 'class' => 'hidden-phone'),
                    array('data' => $cliente->celular, 'class' => 'hidden-phone'),
                    anchor('ventas/catalogos/clientes_referencias/' . $cliente->id_cliente, '<i class="icon-certificate"></i>', array('class' => 'btn btn-small', 'title' => 'Referencias')),
                    anchor('ventas/catalogos/clientes_dependientes/' . $cliente->id_cliente, '<i class="icon-home"></i>', array('class' => 'btn btn-small', 'title' => 'Dependientes')),
                    anchor('ventas/catalogos/clientes_update/' . $cliente->id_cliente, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                    array('data' => anchor('ventas/catalogos/clientes_delete/' . $cliente->id_cliente, '<i class="icon-remove"></i>', array('class' => 'btn btn-small')), 'class' => 'hidden-phone')
    		);
    	}
    	$data['table'] = $this->table->generate();
    	$data['titulo'] = 'Clientes <small>Lista</small>';
    	$data['link_add'] = anchor('ventas/catalogos/clientes_add','<i class="icon-plus"></i> Agregar cliente', array('class' => 'btn'));
    	
    	$this->load->view('ventas/clientes/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Clientes - Agregar
     * -------------------------------------------------------------------------
     * @author: bravoteam
     *
     */
    public function clientes_add() {
    	$this->load->model('ventas/cliente', 'f');
    
    	$data['js'] = array(asset_url() . 'js/jquery.validation.js');
    	$data['titulo'] = 'Clientes <small>Alta</small>';
    	$data['link_back'] = anchor('ventas/catalogos/clientes/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
    
    	$data['mensaje'] = '';
    	$data['action'] = site_url('ventas/catalogos/clientes_add');
    	if ( ($cliente = $this->input->post()) ) {
    		$this->f->save($cliente);
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
    	} 
        $this->load->view('ventas/clientes/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Clientes - Modificar
     * -------------------------------------------------------------------------
     * @author: bravoteam
     *
     * @param int $id
     */
    public function clientes_update($id) {
    	if (!isset($id)) {
    		redirect(site_url('ventas/catalogos/clientes/'));
    	}
    	
    	$id = floatval($id);
    	
    	$data['titulo'] = 'Clientes <small>Modificar</small>';
    	$data['link_back'] = anchor('ventas/catalogos/clientes/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
    	$data['mensaje'] = '';
    	$data['action'] = site_url('ventas/catalogos/clientes_update') . '/' . $id;
    	 
    	$this->load->model('ventas/cliente', 'f');
    	$cliente = $this->f->get_by_id($id)->row();
    	$data['cliente'] = $cliente;
    	if ( ($cliente = $this->input->post()) ) {
    		$this->f->update($id, $cliente);
    		$data['cliente'] = (object)$cliente;
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
    	}
        $this->load->view('ventas/clientes/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Clientes - Borrar
     * -------------------------------------------------------------------------
     * @author: bravoteam
     *
     * @param int $id
     */
    public function clientes_delete($id) {
    	if (!isset($id)) {
    		redirect(site_url('ventas/catalogos/clientes/'));
    	}
    	
    	$id = floatval($id);
    	
    	$this->load->model('ventas/cliente', 'f');
    	$this->f->delete($id);
    	redirect(site_url('ventas/catalogos/clientes/'));
    }

    /**
     * -------------------------------------------------------------------------
     * autocompletar service
     * -------------------------------------------------------------------------
     * 
     */
    public function clientes_autocompletar() {
        $query = $this->input->post('q', true);
        if (isset($query)) {
            $this->load->model('ventas/cliente', 'c');
            $clientes = $this->c->get_by_query($query);
            if ($clientes != false) {
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

?>
