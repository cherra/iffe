<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of calles
 *
 * @author cherra
 */
class Ferias extends CI_Controller{
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     * -------------------------------------------------------------------------
     * Periodos - Lista
     * -------------------------------------------------------------------------
     * 
     * @param int $offset
     */
    public function periodos($offset = 0) {
       
            // obtener datos
        $this->config->load("pagination");
        $this->load->model('periodo', 'm');
        $page_limit = $this->config->item("per_page");
        $lista = $this->m->get_paged_list($page_limit, $offset)->result();

        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url('catalogos/ferias/periodos');
        $config['total_rows'] = $this->m->count_all();
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Nombre', array('data' => 'Inicio', 'class' => 'hidden-phone'), array('data' => 'Fin', 'class' => 'hidden-phone'), 'Estado', '');
        foreach ($lista as $r) {
            $this->table->add_row(
                $r->nombre, 
                array('data' => $r->fecha_inicio, 'class' => 'hidden-phone'),
                array('data' => $r->fecha_fin, 'class' => 'hidden-phone'),
                $r->activo == 1 ? 'Activo' : '-', 
                anchor('catalogos/ferias/periodos_update/' . $r->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small', 'title' => 'Editar')),
                array('data' => anchor('catalogos/ferias/periodos_delete/' . $r->id, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Borrar')), 'class' => 'hidden-phone')
            );
        }

        $data['table'] = $this->table->generate();
        $data['link_add'] = anchor('catalogos/ferias/periodos_add/','<i class="icon-plus"></i> Agregar período', array('class' => 'btn'));
        $data['titulo'] = 'Períodos <small>Listado</small>';
        $this->load->view('catalogos/periodos/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Calles - Agregar
     * -------------------------------------------------------------------------
     */
    public function periodos_add() {
        $data['titulo'] = 'Períodos <small>Alta</small>';
        $data['link_back'] = anchor('catalogos/ferias/periodos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('catalogos/ferias/periodos_add/');
	
        if ( ($datos = $this->input->post()) ) {
           	$this->load->model('periodo', 'm');
           	$this->m->save($datos);
                $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro exitoso</div>';
        }
        $this->load->view('catalogos/periodos/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Calles - Modificar
     * -------------------------------------------------------------------------
     * @param int $id
     */
    public function periodos_update($id = null) {

        if (empty($id)) {
            redirect('catalogos/ferias/periodos');
        }

        $data['titulo'] = 'Períodos <small>Modificar</small>';
        $data['link_back'] = anchor('catalogos/ferias/periodos/','<li class="icon-arrow-left"></li> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('catalogos/ferias/periodos_update') . '/' . $id;
        
        $this->load->model('periodo', 'm');
        $registro = $this->m->get_by_id($id)->row();
        $data['datos'] = $registro;
        
        if ( ($registro = $this->input->post()) ) {
            $this->m->update($id, $registro);
            $data['datos'] = (object)$registro;
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }    
        $this->load->view('catalogos/periodos/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Calles - Borrar
     * -------------------------------------------------------------------------
     * @param int $id
     */
    public function periodos_delete($id = null) {
        if (!empty($id)) {
            $this->load->model('periodo', 'm');
            $this->m->delete($id);
        }
        redirect('catalogos/ferias/periodos');
    }
    
    /**
     * -------------------------------------------------------------------------
     * Calles - Lista
     * -------------------------------------------------------------------------
     * 
     * @param int $offset
     */
    public function calles($offset = 0) {
       
            // obtener datos
        $this->config->load("pagination");
        $this->load->model('calle', 'm');
        $page_limit = $this->config->item("per_page");
        $lista = $this->m->get_paged_list($page_limit, $offset)->result();

        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url('catalogos/ferias/calles');
        $config['total_rows'] = $this->m->count_all();
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Nombre', array('data' => 'Descripción', 'class' => 'hidden-phone'), 'Módulos',array('data' => 'Precio base', 'class' => 'hidden-phone'), '');
        foreach ($lista as $r) {
            $this->table->add_row(
                $r->nombre, 
                array('data' => $r->descripcion, 'class' => 'hidden-phone'),
                $r->modulos,
                array('data' => number_format($r->precio_base,2,'.',','), 'class' => 'hidden-phone'),
                anchor('catalogos/ferias/modulos/' . $r->id, '<i class="icon-eye-open"></i>', array('class' => 'btn btn-small', 'title' => 'Ver módulos')),
                anchor('catalogos/ferias/calles_update/' . $r->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small', 'title' => 'Editar')),
                array('data' => anchor('catalogos/ferias/calles_delete/' . $r->id, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Borrar')), 'class' => 'hidden-phone')
            );
        }

        $data['table'] = $this->table->generate();
        $data['link_add'] = anchor('catalogos/ferias/calles_add/','<i class="icon-plus"></i> Agregar calle', array('class' => 'btn'));
        $data['titulo'] = 'Calles <small>Listado</small>';
        $this->load->view('catalogos/calles/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Calles - Agregar
     * -------------------------------------------------------------------------
     */
    public function calles_add() {
        $data['titulo'] = 'Calles <small>Alta</small>';
        $data['link_back'] = anchor('catalogos/ferias/calles','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('catalogos/ferias/calles_add/');
	
        if ( ($datos = $this->input->post()) ) {
           	$this->load->model('calle', 'm');
           	$this->m->save($datos);
                $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro exitoso</div>';
        }
        $this->load->view('catalogos/calles/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Calles - Modificar
     * -------------------------------------------------------------------------
     * @param int $id
     */
    public function calles_update($id = null) {

        if (empty($id)) {
            redirect('catalogos/ferias/calles');
        }

        $data['titulo'] = 'Calles <small>Modificar</small>';
        $data['link_back'] = anchor('catalogos/ferias/calles/','<li class="icon-arrow-left"></li> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('catalogos/ferias/calles_update') . '/' . $id;
        
        $this->load->model('calle', 'm');
        $registro = $this->m->get_by_id($id)->row();
        $data['datos'] = $registro;
        
        if ( ($registro = $this->input->post()) ) {
            $this->m->update($id, $registro);
            $data['datos'] = (object)$registro;
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }    
        $this->load->view('catalogos/calles/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Calles - Borrar
     * -------------------------------------------------------------------------
     * @param int $id
     */
    public function calles_delete($id = null) {
        if (!empty($id)) {
            $this->load->model('calle', 'm');
            $this->m->delete($id);
        }
        redirect('catalogos/ferias/calles');
    }
    
    /**
     * -------------------------------------------------------------------------
     * Módulos - Lista por calle
     * -------------------------------------------------------------------------
     * @param int $id_calle
     * @param int $offset
     */
    public function modulos($id_calle = null, $offset = 0) {

        $this->load->model('calle', 'c');
        
        $data['link_add'] = '';
        
        // obtener calles
        $data['calles'] = $this->c->get_all()->result();
        if(!empty($id_calle)){
            $data['calle'] = (object)$this->c->get_by_id($id_calle)->row();

            // obtener datos
            $this->config->load("pagination");
            $this->load->model('modulo', 'm');
            $page_limit = $this->config->item("per_page");
            $lista = $this->m->get_paged_list($id_calle, $page_limit, $offset)->result();

            // generar paginacion
            $this->load->library('pagination');
            $config['base_url'] = site_url('catalogos/ferias/modulos/'.$id_calle);
            $config['total_rows'] = $this->m->count_all($id_calle);
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Núm.', array('data' => 'Medidas', 'class' => 'hidden-phone'), 'Precio', 'Cat.', 'Tipo');

            foreach ($lista as $r) {
                $this->table->add_row(
                    $r->numero,
                    array('data' => $r->frente.'x'.$r->fondo, 'class' => 'hidden-phone'),
                    number_format($r->precio,2,'.',','),
                    ucfirst($r->categoria),
                    ucfirst($r->tipo),
                    anchor('catalogos/ferias/modulos_update/' . $r->id_calle . '/' . $r->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                    array('data' => anchor('catalogos/ferias/modulos_delete/' . $r->id_calle . '/' . $r->id, '<i class="icon-remove"></i>', array('class' => 'btn btn-small')), 'class' => 'hidden-phone')
                );
            }

            $data['table'] = $this->table->generate();
            $data['link_add'] = anchor('catalogos/ferias/modulos_add/' . $id_calle,'<i class="icon-plus"></i> Agregar lote', array('class' => 'btn'));
        }
        $data['link_back'] = anchor('catalogos/ferias/calles','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['titulo'] = 'Módulos <small>Listado</small>';
        $this->load->view('catalogos/modulos/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Modulos - Agregar
     * -------------------------------------------------------------------------
     * @param int $id_calle
     */
    public function modulos_add($id_calle = null) {
        if (empty($id_calle)) {
            redirect('catalogos/ferias/modulos/');
        }
        
        $this->load->model('calle', 'c');
        $data['calle'] = (object)$this->c->get_by_id($id_calle)->row();

        $data['titulo'] = 'Módulos <small>Alta</small>';
        $data['link_back'] = anchor('catalogos/ferias/modulos/' . $id_calle,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('catalogos/ferias/modulos_add/' . $id_calle);
	
        if( ($datos = $this->input->post()) ){
            $this->load->model('modulo', 'm');
            $datos['id_calle'] = $id_calle;
            $this->m->save($datos);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro exitoso</div>';
        }
        $this->load->view('catalogos/modulos/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Módulos - Modificar
     * -------------------------------------------------------------------------
     * @param int $id_calle
     * @param int $id
     */
    public function modulos_update($id_calle = null, $id = null) {

        if ( empty($id_calle) || empty($id) ) {
            redirect('catalogos/ferias/modulos/');
        }
        
        $data['titulo'] = 'Módulos <small>Modificar</small>';
        $data['link_back'] = anchor('catalogos/ferias/modulos/' . $id_calle,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('catalogos/ferias/modulos_update/') . '/' . $id_calle . '/' . $id;
        
        $this->load->model('calle', 'c');
        $calle = $this->c->get_by_id($id_calle)->row();
        $data['calle'] = $calle;
        
        $this->load->model('modulo', 'm');
        $modulo = $this->m->get_by_id($id)->row();
        $data['datos'] = $modulo;
        
        if ( ($datos = $this->input->post()) ) {
            $this->m->update($id, $datos);
            $data['datos'] = (object)$datos;
            
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        $this->load->view('catalogos/modulos/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Módulos - Borrar
     * -------------------------------------------------------------------------
     * @param int $id_calle
     * @param int $id
     */
    public function modulos_delete($id_calle = null, $id = null) {
        if ( empty($id_calle) || empty($id) ) {
            redirect('catalogos/ferias/modulos/');
        }

        $this->load->model('modulo', 'm');
        $this->m->delete($id);
        redirect('catalogos/ferias/modulos/' . '/' . $id_calle);
    }
}

?>
