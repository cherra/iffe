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
class Calles extends CI_Controller{
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     * -------------------------------------------------------------------------
     * Manzanas - Lista por fraccionamiento
     * -------------------------------------------------------------------------
     * @author: nun3z
     * 
     * @param int $id_fraccionamiento
     * @param int $offset
     */
    public function manzanas($id_fraccionamiento = null, $offset = 0) {
        $this->load->model('fraccionamientos/fraccionamiento', 'f');
        $data['fraccionamientos'] = $this->f->get_all()->result();
        
        if (!empty($id_fraccionamiento)) {
            $id_fraccionamiento = floatval($id_fraccionamiento);
            $data['fraccionamiento'] = (object)$this->f->get_by_id($id_fraccionamiento)->row();
            
            // obtener datos
            $this->config->load("pagination");
            $this->load->model('fraccionamientos/manzana', 'm');
            $page_limit = $this->config->item("per_page");
            $manzanas = $this->m->get_paged_list($id_fraccionamiento, $page_limit, $offset)->result();

            // generar paginacion
            $this->load->library('pagination');
            $config['base_url'] = site_url('fraccionamientos/catalogos/manzanas/' . $id_fraccionamiento);
            $config['total_rows'] = $this->m->count_all($id_fraccionamiento);
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '">' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Descripción', array('data' => 'Observaciones', 'class' => 'hidden-phone'), '');
            foreach ($manzanas as $manzana) {
                $this->table->add_row(
                    $manzana->descripcion, 
                    array('data' => $manzana->observaciones, 'class' => 'hidden-phone'),
                    anchor('fraccionamientos/catalogos/lotes/' . $manzana->id_fraccionamiento . '/' . $manzana->id_manzana, '<i class="icon-eye-open"></i>', array('class' => 'btn btn-small', 'title' => 'Ver detalles')),
                    anchor('fraccionamientos/catalogos/manzanas_update/' . $manzana->id_fraccionamiento . '/' . $manzana->id_manzana, '<i class="icon-edit"></i>', array('class' => 'btn btn-small', 'title' => 'Editar')),
                    array('data' => anchor('fraccionamientos/catalogos/manzanas_delete/' . $manzana->id_fraccionamiento . '/' . $manzana->id_manzana, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Borrar')), 'class' => 'hidden-phone')
                );
            }

            $data['table'] = $this->table->generate();
            $data['link_add'] = anchor('fraccionamientos/catalogos/manzanas_add/' . $id_fraccionamiento,'<i class="icon-plus"></i> Agregar manzana', array('class' => 'btn'));
        }
        
        $data['link_back'] = anchor('fraccionamientos/catalogos/fraccionamientos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['titulo'] = 'Manzanas <small>Listado</small>';
        $this->load->view('fraccionamientos/manzanas/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Manzanas - Agregar
     * -------------------------------------------------------------------------
     * @author: nun3z
     * 
     * @param int $id_fraccionamiento
     */
    public function manzanas_add($id_fraccionamiento) {
        if (isset($id_fraccionamiento) && ($id_fraccionamiento > 0)) {
			$this->load->model('fraccionamientos/fraccionamiento', 'f');
            $data['fraccionamiento'] = (object)$this->f->get_by_id($id_fraccionamiento)->row();
        }
        else {
            redirect(site_url('fraccionamientos/catalogos/manzanas/') . '/' . $id_fraccionamiento);
        }

        $data['titulo'] = 'Manzanas <small>Alta</small>';
        $data['link_back'] = anchor('fraccionamientos/catalogos/manzanas/' . $id_fraccionamiento,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
		$data['mensaje'] = '';
		$data['action'] = site_url('fraccionamientos/catalogos/manzanas_add/' . $id_fraccionamiento);
	
        if ($this->input->post() == false) {
            $this->load->view('fraccionamientos/manzanas/formulario', $data);
        }
        else {
           	$manzana = array(
               	'id_fraccionamiento' => $id_fraccionamiento,
				'descripcion' => $this->input->post('descripcion', true),
               	'observaciones' => $this->input->post('observaciones', true)
           	);
           	$this->load->model('fraccionamientos/manzana', 'm');
           	$this->m->save($manzana);
			$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
	   		$this->load->view('fraccionamientos/manzanas/formulario', $data);
        }
    }
    
    /**
     * -------------------------------------------------------------------------
     * Manzanas - Modificar
     * -------------------------------------------------------------------------
     * @author: nun3z
     * 
     * @param int $id_fraccionamiento
     * @param int $id_manzana
     */
    public function manzanas_update($id_fraccionamiento, $id_manzana) {

        if (!isset($id_fraccionamiento)) {
            redirect(site_url('fraccionamientos/catalogos/manzanas/') . '/' . $id_fraccionamiento);
        }
        
        if (!isset($id_manzana)) {
            redirect(site_url('fraccionamientos/catalogos/manzanas/') . '/' . $id_fraccionamiento);
        }

        $id_fraccionamiento = floatval($id_fraccionamiento);
        $id_manzana = floatval($id_manzana);
        
        $data['titulo'] = 'Manzanas - Modificar';
        $data['link_back'] = anchor('fraccionamientos/catalogos/manzanas/' . $id_fraccionamiento,'<li class="icon-arrow-left"></li> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('fraccionamientos/catalogos/manzanas_update') . '/' . $id_fraccionamiento . '/' . $id_manzana;
        
        $this->load->model('fraccionamientos/fraccionamiento','f');
        $fraccionamiento = $this->f->get_by_id($id_fraccionamiento)->row();
        $data['fraccionamiento'] = $fraccionamiento;
        
        $this->load->model('fraccionamientos/manzana', 'm');
        $manzana = $this->m->get_by_id($id_manzana)->row();
        $data['manzana'] = $manzana;
        
        if ($this->input->post() == false) {
            $this->load->view('fraccionamientos/manzanas/formulario', $data);
        }
        else {
            $manzana = array(
                        'descripcion' => $this->input->post('descripcion', true),
                        'observaciones' => $this->input->post('observaciones', true)
                        );
            $this->m->update($id_manzana, $manzana);
            $data['manzana'] = (object)$manzana;
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
            $this->load->view('fraccionamientos/manzanas/formulario', $data);
        }    
    }
    
    /**
     * -------------------------------------------------------------------------
     * Manzanas - Borrar
     * -------------------------------------------------------------------------
     * @author: nun3z
     * 
     * @param int $id_fraccionamiento
     * @param int $id_manzana
     */
    public function manzanas_delete($id_fraccionamiento, $id_manzana) {
        if (!isset($id_fraccionamiento)) {
            redirect(site_url('fraccionamientos/catalogos/fraccionamientos/') . '/' . $id_fraccionamiento);
        }
        
        if (!isset($id_manzana)) {
            redirect(site_url('fraccionamientos/catalogos/fraccionamientos/') . '/' . $id_fraccionamiento);
        }

        $id_fraccionamiento = floatval($id_fraccionamiento);
        $id_manzana = floatval($id_manzana);
        
        $this->load->model('fraccionamientos/manzana', 'm');
        $this->m->delete($id_manzana);
        redirect(site_url('fraccionamientos/catalogos/manzanas/') . '/' . $id_fraccionamiento);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Lotes - Lista por manzana
     * -------------------------------------------------------------------------
     * @author: nun3z
     * 
     * @param int $id_fraccionamiento
     * @param int $id_manzana
     * @param int $offset
     */
    public function lotes($id_fraccionamiento = null, $id_manzana = null, $offset = 0) {

        $this->load->model('fraccionamientos/fraccionamiento', 'f');
        $this->load->model('fraccionamientos/manzana', 'm');
        
        $data['link_add'] = '';
        
        // obtener todos los fraccionamientos
        $data['fraccionamientos'] = $this->f->get_all()->result();

    	if (!empty($id_fraccionamiento)) {
	    	
            // obtener manzanas por fraccionamiento
            $data['manzanas'] = $this->m->get_all($id_fraccionamiento)->result();

            $id_fraccionamiento = floatval($id_fraccionamiento);
            $data['fraccionamiento'] = (object)$this->f->get_by_id($id_fraccionamiento)->row();

            if(!empty($id_manzana)){
                $id_manzana = floatval($id_manzana);
                $data['manzana'] = (object)$this->m->get_by_id($id_manzana)->row();

                // obtener datos
                $this->config->load("pagination");
                $this->load->model('fraccionamientos/lote', 'l');
                $page_limit = $this->config->item("per_page");
                $lotes = $this->l->get_paged_list($id_manzana, $page_limit, $offset)->result();

                // generar paginacion
                $this->load->library('pagination');
                $config['base_url'] = site_url('fraccionamientos/catalogos/manzanas/' . $id_fraccionamiento);
                $config['total_rows'] = $this->l->count_all($id_manzana);
                $config['uri_segment'] = 6;
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();

                // generar tabla
                $this->load->library('table');
                $this->table->set_empty('&nbsp;');
                $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
                $this->table->set_template($tmpl);
                $this->table->set_heading('Descripción', 'Superficie', array('data' => 'Calle', 'class' => 'hidden-phone'), array('data' => 'Número', 'class' => 'hidden-phone'), array('data' => 'Precio', 'class' => 'hidden-phone'), '', '');

                foreach ($lotes as $r) {
                    $this->table->add_row(
                        $r->descripcion,
                        number_format($r->superficie,2,'.',','),
                        array('data' => $r->calle, 'class' => 'hidden-phone'),
                        array('data' => $r->numero, 'class' => 'hidden-phone'),
                        array('data' => number_format($r->precio,2,'.',','), 'class' => 'hidden-phone'),
                        anchor('fraccionamientos/catalogos/lotes_update/' . $id_fraccionamiento . '/' . $r->id_manzana . '/' . $r->id_lote, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                        anchor('fraccionamientos/catalogos/lotes_delete/' . $id_fraccionamiento . '/' . $r->id_manzana . '/' . $r->id_lote, '<i class="icon-remove"></i>', array('class' => 'btn btn-small'))
                    );
                }

                $data['table'] = $this->table->generate();
                $data['link_add'] = anchor('fraccionamientos/catalogos/lotes_add/' . $id_fraccionamiento . '/' . $id_manzana,'<i class="icon-plus"></i> Agregar lote', array('class' => 'btn'));
            }
    	}
        
        $data['link_back'] = anchor('fraccionamientos/catalogos/manzanas/' . $id_fraccionamiento,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['titulo'] = 'Lotes <small>Listado</small>';
        $this->load->view('fraccionamientos/lotes/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Lotes - Agregar
     * -------------------------------------------------------------------------
     * @author: nun3z
     * 
     * @param int $id_fraccionamiento
     * @param int $id_manzana
     */
    public function lotes_add($id_fraccionamiento, $id_manzana) {
        if ((!isset($id_fraccionamiento) && ($id_fraccionamiento <= 0)) || (!isset($id_fraccionamiento) && ($id_fraccionamiento <= 0))) {
            redirect(site_url('fraccionamientos/catalogos/lotes/') . '/' . $id_fraccionamiento . '/' . $id_manzana);
        }
        
        $this->load->model('fraccionamientos/fraccionamiento', 'f');
        $data['fraccionamiento'] = (object)$this->f->get_by_id($id_fraccionamiento)->row();

        $this->load->model('fraccionamientos/manzana', 'm');
        $data['manzana'] = (object)$this->m->get_by_id($id_manzana)->row();

        $this->load->model('fraccionamientos/lote', 'l');
        $categorias = $this->l->get_paged_list_categorias($id_fraccionamiento)->result();
        $data['categorias'] = $categorias;
        
        $data['titulo'] = 'Lotes <small>Alta</small>';
        $data['link_back'] = anchor('fraccionamientos/catalogos/lotes/' . $id_fraccionamiento . '/' . $id_manzana,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('fraccionamientos/catalogos/lotes_add/' . $id_fraccionamiento . '/' . $id_manzana);
	
        if( ($lote = $this->input->post()) ){
            $lote['id_manzana'] = $id_manzana;
            $this->l->save($lote);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
        }
        $this->load->view('fraccionamientos/lotes/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Lotes - Modificar
     * -------------------------------------------------------------------------
     * @author: nun3z
     * 
     * @param int $id_fraccionamiento
     * @param int $id_manzana
     * @param int $id_lote
     */
    public function lotes_update($id_fraccionamiento = null, $id_manzana = null, $id_lote = null) {

        if ( empty($id_fraccionamiento) || empty($id_manzana) || empty($id_lote) ) {
            redirect(site_url('fraccionamientos/catalogos/lotes/') . '/' . $id_fraccionamiento . '/' . $id_manzana);
        }
        
        $data['titulo'] = 'Lotes <small>Modificar</small>';
        $data['link_back'] = anchor('fraccionamientos/catalogos/lotes/' . $id_fraccionamiento . '/' . $id_manzana,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('fraccionamientos/catalogos/lotes_update/') . '/' . $id_fraccionamiento . '/' . $id_manzana . '/' . $id_lote;
        
        $this->load->model('fraccionamientos/fraccionamiento','f');
        $fraccionamiento = $this->f->get_by_id($id_fraccionamiento)->row();
        $data['fraccionamiento'] = $fraccionamiento;
        
        $this->load->model('fraccionamientos/manzana', 'm');
        $manzana = $this->m->get_by_id($id_manzana)->row();
        $data['manzana'] = $manzana;
        
        $this->load->model('fraccionamientos/lote', 'l');
        $lote = $this->l->get_by_id($id_lote)->row();
        $data['lote'] = $lote;
        
        $categorias = $this->l->get_paged_list_categorias($id_fraccionamiento)->result();
        $data['categorias'] = $categorias;
        $categoria = $this->l->get_by_id_categoria($lote->id_categoria)->row();
        $data['categoria'] = $categoria;
        
        if ( ($lote = $this->input->post()) ) {
            $this->l->update($id_lote, $lote);
            $data['lote'] = (object)$lote;
            
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        $this->load->view('fraccionamientos/lotes/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Lotes - Borrar
     * -------------------------------------------------------------------------
     * @author: nun3z
     * 
     * @param int $id_fraccionamiento
     * @param int $id_manzana
     * @param int $id_lote
     */
    public function lotes_delete($id_fraccionamiento = null, $id_manzana = null, $id_lote = null) {
        if ( empty($id_fraccionamiento) || empty($id_manzana) || empty($id_lote) ) {
            redirect(site_url('fraccionamientos/catalogos/lotes/') . '/' . $id_fraccionamiento . '/' . $id_manzana);
        }

        $this->load->model('fraccionamientos/lote', 'l');
        $this->l->delete($id_lote);
        redirect(site_url('fraccionamientos/catalogos/lotes/') . '/' . $id_fraccionamiento . '/' . $id_manzana);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Categorías de lotes - Listado
     * -------------------------------------------------------------------------
     * @author: cherra
     * 
     * @param int $id_fraccionamiento
     * @param int $offset
     */
    public function categorias_lotes($id_fraccionamiento = null, $offset = 0){
        $this->load->model('fraccionamientos/fraccionamiento', 'f');
        $data['fraccionamientos'] = $this->f->get_all()->result();
        
        if (!empty($id_fraccionamiento)) {
            $id_fraccionamiento = floatval($id_fraccionamiento);
            $data['fraccionamiento'] = (object)$this->f->get_by_id($id_fraccionamiento)->row();
            
            // obtener datos
            $this->config->load("pagination");
            $this->load->model('fraccionamientos/lote', 'l');
            $page_limit = $this->config->item("per_page");
            $categorias = $this->l->get_paged_list_categorias($id_fraccionamiento, $page_limit, $offset)->result();

            // generar paginacion
            $this->load->library('pagination');
            $config['base_url'] = site_url('fraccionamientos/catalogos/categorias_lotes/' . $id_fraccionamiento);
            $config['total_rows'] = $this->l->count_all_categorias($id_fraccionamiento);
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '">' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Descripción', 'Precio', array('data' => 'Observaciones', 'class' => 'hidden-phone'), '');
            foreach ($categorias as $categoria) {
                $this->table->add_row(
                    $categoria->descripcion, 
                    number_format($categoria->precio_metro,2,'.',','), 
                    array('data' => $categoria->observaciones, 'class' => 'hidden-phone'),
                    anchor('fraccionamientos/catalogos/categorias_lotes_update/' . $categoria->id_fraccionamiento . '/' . $categoria->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small', 'title' => 'Editar')),
                    array('data' => anchor('fraccionamientos/catalogos/categorias_lotes_delete/' . $categoria->id_fraccionamiento . '/' . $categoria->id, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Borrar')), 'class' => 'hidden-phone')
                );
            }

            $data['table'] = $this->table->generate();
            $data['link_add'] = anchor('fraccionamientos/catalogos/categorias_lotes_add/' . $id_fraccionamiento,'<i class="icon-plus"></i> Agregar categoría', array('class' => 'btn'));
        }
        
        $data['link_back'] = anchor('fraccionamientos/catalogos/fraccionamientos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['titulo'] = 'Categorías de lotes <small>Listado</small>';
        $this->load->view('fraccionamientos/categorias_lotes/lista', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Manzanas - Agregar
     * -------------------------------------------------------------------------
     * @author: cherra
     * 
     * @param int $id_fraccionamiento
     */
    public function categorias_lotes_add($id_fraccionamiento = null) {
        if (!empty($id_fraccionamiento)) {
            $this->load->model('fraccionamientos/fraccionamiento', 'f');
            $data['fraccionamiento'] = (object)$this->f->get_by_id($id_fraccionamiento)->row();
        }
        else {
            redirect(site_url('fraccionamientos/catalogos/categorias_lotes/') );
        }

        $data['titulo'] = 'Categorías de lotes <small>Alta</small>';
        $data['link_back'] = anchor('fraccionamientos/catalogos/categorias_lotes/' . $id_fraccionamiento,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('fraccionamientos/catalogos/categorias_lotes_add/' . $id_fraccionamiento);
	
        if ( ($categoria = $this->input->post()) ) {
            $categoria['id_fraccionamiento'] = $id_fraccionamiento;
            $this->load->model('fraccionamientos/lote', 'l');
            if( $this->l->save_categoria($categoria) > 0 )
                $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro exitoso!</div>';
        }
        $this->load->view('fraccionamientos/categorias_lotes/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Manzanas - Modificar
     * -------------------------------------------------------------------------
     * @author: cherra
     * 
     * @param int $id_fraccionamiento
     * @param int $id_categoria
     */
    public function categorias_lotes_update( $id_fraccionamiento = null, $id_categoria = null ) {

        if ( empty($id_fraccionamiento) || empty($id_categoria) ) {
            redirect(site_url('fraccionamientos/catalogos/categorias_lotes/') . '/' . $id_fraccionamiento);
        }

        $id_fraccionamiento = floatval($id_fraccionamiento);
        //$id_manzana = floatval($id_manzana);
        
        $data['titulo'] = 'Categorias de lotes <small>Modificar</small>';
        $data['link_back'] = anchor('fraccionamientos/catalogos/categorias_lotes/' . $id_fraccionamiento,'<li class="icon-arrow-left"></li> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('fraccionamientos/catalogos/categorias_lotes_update') . '/' . $id_fraccionamiento . '/' . $id_categoria;
        
        $this->load->model('fraccionamientos/fraccionamiento','f');
        $fraccionamiento = $this->f->get_by_id($id_fraccionamiento)->row();
        $data['fraccionamiento'] = $fraccionamiento;
        
        $this->load->model('fraccionamientos/lote', 'l');
        $categoria = $this->l->get_by_id_categoria($id_categoria)->row();
        $data['categoria'] = $categoria;
        
        if ( ($categoria = $this->input->post()) ) {
            if( $this->l->update_categoria( $id_categoria, $categoria ) > 0 )
                    $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
            $data['categoria'] = (object)$categoria;
        }
        $this->load->view('fraccionamientos/categorias_lotes/formulario', $data);
    }
    
    /**
     * -------------------------------------------------------------------------
     * Categorías de lotes - Borrar
     * -------------------------------------------------------------------------
     * @author: cherra
     * 
     * @param int $id_fraccionamiento
     * @param int $id_categoria
     */
    public function categorias_lotes_delete( $id_fraccionamiento = null, $id_categoria = null ) {
        if ( empty($id_fraccionamiento) || empty($id_categoria) ) {
            redirect(site_url('fraccionamientos/catalogos/categorias_lotes/') . '/' . $id_fraccionamiento);
        }

        $this->load->model('fraccionamientos/lote', 'l');
        $this->l->delete_categoria($id_categoria);
        redirect(site_url('fraccionamientos/catalogos/categorias_lotes/') . '/' . $id_fraccionamiento);
    }
}

?>
