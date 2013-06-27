<?php

/**
 * Description of preferencias
 *
 * @author cherra
 */
class Preferencias extends CI_Controller{
    
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('preferencias/preferencias');
    }
    
    public function configuracion_lista(){
        $this->titulo = "Parametros de configuración";
        
        // obtener offset
        $uri_segment = 4;
        $offset = $this->uri->segment($uri_segment);
        
        // obtener datos
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        $parametros = $this->configuracion->get_paged_list($page_limit, $offset)->result();

        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url('preferencias/configuracion/');
        $config['total_rows'] = $this->configuracion->count_all();
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Key', 'Valor', 'Descripcion');
        foreach ($parametros as $parametro) {
                $this->table->add_row(
                        $parametro->key, 
                        $parametro->valor,
                        $parametro->descripcion,
                        anchor('preferencias/preferencias/configuracion_update/' . $parametro->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small')),
                        anchor('preferencias/preferencias/configuracion_delete/' . $parametro->id, '<i class="icon-remove"></i>', array('class' => 'btn btn-small'))
                );
        }
        $data['table'] = $this->table->generate();

        $data['link_add'] = anchor('preferencias/preferencias/configuracion_add/','<i class="icon-plus icon-white"></i> Agregar', array('class' => 'btn btn-inverse'));
        $data['titulo'] = $this->titulo . ' <small>Lista</small>';

        $this->load->view('preferencias/configuracion/lista', $data);
    }
    
    public function configuracion_add(){
        $data['titulo'] = 'Configuración <small>Agregar</small>';
        $data['link_back'] = anchor('preferencias/preferencias/configuracion_lista/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('preferencias/preferencias/configuracion_add');
        
        if( $this->input->post() ) {
            $parametro = array(
                'key' => $this->input->post('key', true),
                'valor' => $this->input->post('valor', true),
                'descripcion' => $this->input->post('descripcion', true)
            );
            $this->configuracion->save($parametro);
            
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
        }
        $this->load->view('preferencias/configuracion/formulario', $data);
    }
    
    public function configuracion_update( $id ){
        if (!isset($id)) {
            redirect(site_url('preferencias/preferencias/configuracion_lista/'));
        }
        
        $id = floatval($id);

        $data['titulo'] = 'Configuración - Modificar';
        $data['link_back'] = anchor('preferencias/preferencias/configuracion_lista/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('preferencias/preferencias/configuracion_update') . '/' . $id;
	
        $data['parametro'] = $this->configuracion->get_by_id($id)->row();;
        
        if( $this->input->post() ) {
            $parametro = array(
                'key' => $this->input->post('key'),
                'valor' => $this->input->post('valor'),
                'descripcion' => $this->input->post('descripcion')
            );
            
            $this->configuracion->set_valor($id, $parametro);
            $data['parametro'] = (object)$parametro;
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        $this->load->view('preferencias/configuracion/formulario', $data);
    }
    
    public function configuracion_delete( $id ){
        if(!empty($id)){
            $id = floatval($id);
            $this->configuracion->delete($id);
        }
        redirect(site_url('preferencias/preferencias/configuracion_lista/'));
    }
}

?>
