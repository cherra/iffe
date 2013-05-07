<?php

class Ferias extends CI_Controller{
    
    public $layout = 'template_backend';
    private $upload_path;
    
    function __construct() {
        parent::__construct();
        $this->upload_path = $this->config->item('contratos_adjuntos_path');
    }
    
    public function ferias_lista(){
        $this->load->view('operacion/ferias/lista');
    }
    
    /**
     * ----------------------------------------------------
     * Métodos para contratos
     * ----------------------------------------------------
     */
    
    public function contratos( $offset = 0 ){
        $this->load->model('contrato','a');
        
        $offset = floatval($offset);
        
        // generar paginacion
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        $contrados = $this->a->get_paged_list($page_limit, $offset)->result();
        $this->load->library('pagination');
        $config['base_url'] = site_url('operacion/ferias/contratos/');
        $config['total_rows'] = $this->a->count_all();
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('No hay contratos por mostrar');
        $tmpl = array ('table_open'  => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Fraccionamiento', array('data' => 'Manzana', 'class' => 'hidden-phone'), array('data' => 'Lote', 'class' => 'hidden-phone'), 'Cliente', array('data' => 'Fecha', 'class' => 'hidden-phone'));
        foreach ($contrados as $contrato) {
            $this->table->add_row(
                $contrato->fraccionamiento, 
                array('data' => $contrato->manzana, 'class' => 'hidden-phone'),
                array('data' => $contrato->lote, 'class' => 'hidden-phone'),
                $contrato->cliente,
                array('data' => $contrato->fecha, 'class' => 'hidden-phone'),
                array('data' => anchor_popup('operacion/ferias/contratos_documento/' . $contrato->id_contrato, '<i class="icon-print"></i>', array('class' => 'btn btn-small', 'title' => 'Imprimir')), 'class' => 'hidden-phone'),
                anchor('operacion/ferias/contratos_adjuntos/' . $contrato->id_contrato, '<i class="icon-file"></i>', array('class' => 'btn btn-small', 'title' => 'Adjuntos')),
                anchor('operacion/ferias/contratos_proceso/' . $contrato->id_contrato, '<i class="icon-th-list"></i>', array('class' => 'btn btn-small', 'title' => 'Procesos')),
                array('data' => anchor('operacion/ferias/contratos_update/' . $contrato->id_contrato, '<i class="icon-edit"></i>', array('class' => 'btn btn-small', 'title' => 'Modificar')), 'class' => 'hidden-phone'),
                array('data' => anchor('operacion/ferias/contratos_delete/' . $contrato->id_contrato, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Borrar')), 'class' => 'hidden-phone')
            );
        }
        
        $data['pagination'] = $this->pagination->create_links();
        $data['table'] = $this->table->generate();
        $data['titulo'] = 'Contratos <small>Listado</small>';
        $data['add_link'] = anchor('operacion/ferias/contratos_add/','<i class="icon-plus"></i> Agregar', array('class' => 'btn'));
        
        $this->load->view('operacion/contratos/lista', $data);
    }
    
    public function contratos_add( $id_calle = null, $id_modulo = null, $id_cliente = null, $fecha = null ){
        
        $data['titulo'] = 'Contratos <small>Alta</small>';
        $data['link_back'] = anchor('operacion/ferias/contratos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ferias/contratos_add');
	
        $this->load->model('modulo','m');
        $this->load->model('calle','ca');
        $this->load->model('cliente','c');

        $data['calles'] = $this->ca->get_paged_list()->result();
        
        if(!empty($id_calle)){
            $data['id_calle'] = $id_calle;
            $data['modulos'] = $this->m->get_disponibles($id_calle)->result();
        }
        if(!empty($id_modulo)){
            $data['id_modulo'] = $id_modulo;
            $data['modulo'] = $this->m->get_by_id($id_modulo)->row();
        }
        if(!empty($id_cliente)){
            $data['cliente'] = $this->c->get_by_id($id_cliente)->row();
        }
        
        // Establece la fecha para el registro del apartado y
        // Calcula la fecha de vencimiento del mismo
        if(empty($fecha)){
            $fecha = date_create();
        }else{
            $fecha = date_create($fecha);
        }
        $data['fecha'] = date_format($fecha,'Y-m-d');
        date_add($fecha, date_interval_create_from_date_string($this->configuracion->get_valor('contrato_vencimiento').' days'));
        $data['fecha_vencimiento'] = date_format($fecha, 'Y-m-d');;
        
        if ( ($datos = $this->input->post()) ) {
            $this->load->model('contrato', 'co');
            
            if( ($ultimo_contrato = $this->co->get_last()->row()) )
                $contrato['numero'] = $ultimo_contrato->numero + 1;
            else
                $contrato['numero'] = 1;
            $this->co->save($contrato);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Contrato registrado</div>';
        }
        $this->load->view('operacion/contratos/formulario', $data);
    }
    
    
    public function contratos_update( $id = null ){
        $this->load->model('contrato', 'co');
        
        if (empty($id)) {
            redirect(site_url('operacion/ferias/contratos/'));
        }
        
        $this->load->model('apartado','a');
        $this->load->model('cliente','c');
        
        $this->load->model('fraccionamientos/fraccionamiento','f');
        $this->load->model('fraccionamientos/manzana','m');
        $this->load->model('fraccionamientos/lote','l');
        
        
        $id = floatval($id);

        $data['titulo'] = 'Contratos <small>Modificar</small>';
        $data['link_back'] = anchor('operacion/ferias/contratos/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ferias/contratos_update') . '/' . $id;
	
        $contrato = $this->co->get_by_id($id)->row();
        $data['contrato'] = $contrato;
        $lote = $this->l->get_by_id($contrato->id_lote)->row();
        $manzana = $this->m->get_by_id($lote->id_manzana)->row();
        $fraccionamiento = $this->f->get_by_id($manzana->id_fraccionamiento)->row();
        $cliente = $this->c->get_by_id($contrato->id_cliente)->row();
        
        $data['id_apartado'] = $contrato->id_apartado;
        $data['id_fraccionamiento'] = $fraccionamiento->id_fraccionamiento;
        $data['id_manzana'] = $manzana->id_manzana;
        $data['id_lote'] = $lote->id_lote;
        $data['cliente'] = $cliente;
        
        $data['apartados'] = $this->a->get_vigentes()->result();
        // Se agrega a la lista el apartado asignado al contrato
        $data['apartados'][] = $this->a->get_by_id($contrato->id_apartado)->row();
        
        $data['fraccionamientos'] = $this->f->get_paged_list()->result();
        $data['manzanas'] = $this->m->get_paged_list($manzana->id_fraccionamiento)->result();
        $data['lotes'] = $this->l->get_paged_list($lote->id_manzana)->result();
        
        if( $this->input->post() ) {
            $contrato = array(
                'id_apartado' => $this->input->post('id_apartado'),
                'id_usuario' => $this->session->userdata('userid'),
                'fecha' => $this->input->post('fecha'),
                'fecha_vencimiento' => $this->input->post('fecha_vencimiento'),
                'observaciones' => $this->input->post('observaciones')
            );
            
            $this->co->update($id, $contrato);
            $data['contrato'] = (object)$contrato;
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        $this->load->view('operacion/contratos/formulario', $data);
    }
    
    public function contratos_delete( $id = null ) {
        $this->load->model('contrato', 'c');
        
        if(!empty($id)){
            $id = floatval($id);

            $this->c->delete($id);
        }
        redirect(site_url('operacion/ferias/contratos/'));
    }

    /**
     * --------------------------------------------------------
     * Contratos proceso
     * --------------------------------------------------------
     */
    public function contratos_proceso($id) {
        
        if (empty($id)) {
            redirect(site_url('operacion/ferias/contratos/'));
        }
        
        $this->load->model('contrato', 'c');
        $this->load->model('fraccionamientos/proceso', 'p');

        $data['titulo'] = 'Contrato <small>Procesos</small>';
        $data['link_back'] = anchor('operacion/ferias/contratos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['contrato'] = (object)$this->c->get_by_id($id)->row();
        $data['action'] = site_url('operacion/ferias/contratos_proceso') . '/' . $id;
        $data['mensaje'] = '';
        
        $data['procesos_not'] = $this->p->get_procesos_not_contrato($id);
        $data['procesos'] = $this->p->get_procesos_contrato($id);

        if ( $this->input->post() ) {
            $datos = array(
                'id_proceso' => $this->input->post('id_proceso', true),
                'id_contrato' => $this->input->post('id_contrato', true)
            );
            $this->load->model('contrato', 'c');
            $this->c->save_proceso($id, $datos);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
            $data['procesos_not'] = $this->p->get_procesos_not_contrato($id);
            $data['procesos'] = $this->p->get_procesos_contrato($id);
        }

        $this->load->view('operacion/contratos/contratos_proceso', $data);

    }
    
    /********************
     *  Impresión de recibos de apartados
     * 
     ********************/
    public function contratos_documento( $id = null ){
        if(!empty($id)){
            $this->layout = "template_backend_wo_menu";
            $this->load->model('contrato', 'a');
            if( $this->session->flashdata('pdf') ){
                $contrato = $this->a->get_by_id($id)->row();
                if($contrato){
                    $this->load->library('tbs');
                    $this->load->library('numero_letras');
                    
                    // Nombres de meses en español (config/sitio.php)
                    $meses = $this->config->item('meses');
                    
                    // Se carga el template predefinido para los recibos (tabla Configuracion)
                    $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_contratos'));
                    
                    // Se sustituyen los campos en el template
                    $this->tbs->VarRef['numero'] = $contrato->numero;
                    $this->tbs->VarRef['cliente'] = $contrato->cliente;
                    $this->tbs->VarRef['fraccionamiento'] = $contrato->fraccionamiento;
                    $this->tbs->VarRef['calle'] = $contrato->calle;
                    $this->tbs->VarRef['numero'] = $contrato->numero_contrato;
                    $fecha_vencimiento = date_create($contrato->fecha_vencimiento);
                    $this->tbs->VarRef['fecha_vencimiento'] = date_format($fecha_vencimiento,'d/F/Y');
                    $this->tbs->VarRef['dia_vencimiento'] = date_format($fecha_vencimiento,'d');
                    $this->tbs->VarRef['mes_vencimiento'] = $meses[date_format($fecha_vencimiento,'n')-1];
                    $this->tbs->VarRef['ano_vencimiento'] = date_format($fecha_vencimiento,'Y');
                    $fecha = date_create($contrato->fecha);
                    $this->tbs->VarRef['dia'] = date_format($fecha,'d');
                    $this->tbs->VarRef['mes'] = $meses[date_format($fecha,'n')-1];
                    $this->tbs->VarRef['ano'] = date_format($fecha,'Y');
                    $this->tbs->VarRef['precio_casa'] = number_format($contrato->precio_casa,2,'.',',');
                    $this->tbs->VarRef['cantidad_letra'] = $this->numero_letras->convertir($contrato->precio_casa);
                    $this->tbs->VarRef['ciudad'] = $contrato->ciudad;
                    $this->tbs->VarRef['estado'] = $contrato->estado;
                    // Render sin desplegar en navegador
                    $this->tbs->Show(TBS_NOTHING);
                    // Se almacena el render en el array $data
                    $data['contenido'] = $this->tbs->Source;
                    $this->load->view('documento', $data);
                }else{
                    redirect('operacion/ferias/contratos');
                }
            }else{
                $this->session->set_flashdata('pdf', true);
                redirect('operacion/ferias/contratos_documento/'.$id); // Se recarga el método para imprimirlo como PDF
            }
        }else{
            redirect('operacion/ferias/contratos');
        }
    }
    
    
    public function contratos_adjuntos($id_contrato = null, $offset = 0){
        $this->load->model('contrato', 'c');
        $data['contratos'] = $this->c->get_paged_list()->result();
        
        if (!empty($id_contrato)) {
            $id_contrato = floatval($id_contrato);
            $data['contrato'] = (object)$this->c->get_by_id($id_contrato)->row();
            
            // obtener datos
            $this->config->load("pagination");
            //$this->load->model('fraccionamientos/manzana', 'm');
            $page_limit = $this->config->item("per_page");
            $adjuntos = $this->c->get_paged_list_adjuntos($id_contrato, $page_limit, $offset)->result();

            // generar paginacion
            $this->load->library('pagination');
            $config['base_url'] = site_url('operacion/ferias/contratos_adjunto/' . $id_contrato);
            $config['total_rows'] = $this->c->count_all_adjuntos($id_contrato);
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '">' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Descripcion', array('data' => 'Observaciones', 'class' => 'hidden-phone'), 'Archivo');
            foreach ($adjuntos as $adjunto) {
                $this->table->add_row(
                    $adjunto->descripcion,
                    array('data' => $adjunto->observaciones, 'class' => 'hidden-phone'),
                    $adjunto->file_name,
                    '<a href="#" path="'.base_url().$adjunto->path . $id_contrato . '/' . $adjunto->file_name.'" class="btn btn-small" title="Ver" preview_link><i class="icon-eye-open"></i></a>',
                    array('data' => '<a href="'.base_url().$adjunto->path . $id_contrato . '/' . $adjunto->file_name.'" class="btn btn-small" title="Descargar"><i class="icon-download"></i></a>', 'class' => 'hidden-phone'),
                    array('data' => anchor('operacion/ferias/contratos_adjuntos_update/' . $adjunto->id_adjunto . '/' . $adjunto->id_contrato, '<i class="icon-edit"></i>', array('class' => 'btn btn-small', 'title' => 'Modificar')), 'class' => 'hidden-phone'),
                    array('data' => anchor('operacion/ferias/contratos_adjuntos_delete/' . $adjunto->id_adjunto . '/' . $adjunto->id_contrato, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Borrar')), 'class' => 'hidden-phone')
                );
            }

            $data['table'] = $this->table->generate();
            $data['link_add'] = anchor('operacion/ferias/contratos_adjuntos_add/' . $id_contrato,'<i class="icon-plus"></i> Agregar adjunto', array('class' => 'btn'));
        }
        
        $data['link_back'] = anchor('operacion/ferias/contratos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['titulo'] = 'Contrato <small>Adjuntos</small>';
        $this->load->view('operacion/contratos/lista_adjuntos', $data);
    }
    
    public function contratos_adjuntos_add($id_contrato = null) {
        if (!empty($id_contrato)) {
            $this->load->model('contrato', 'c');
            $data['contrato'] = (object)$this->c->get_by_id($id_contrato)->row();
        }
        else {
            redirect(site_url('operacion/ferias/contratos_adjuntos/') . '/' . $id_contrato);
        }

        $data['titulo'] = 'Adjuntos de Contrato <small>Agregar</small>';
        $data['link_back'] = anchor('operacion/ferias/contratos_adjuntos/' . $id_contrato,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ferias/contratos_adjuntos_add/' . $id_contrato);
	
        if ( $this->input->post() ) {
            // Se define la ruta donde se va a guardar el archivo y se valida si existe y es escribible.
            $path = $this->upload_path.$id_contrato.'/';
            if(!file_exists($path)){
                mkdir($path, 0777, true);
            }elseif(!is_writable($path)){
                chmod($path, 0777);
            }

            $this->config->load('upload', TRUE); // Se carga el archivo de configuracion upload.php 
            $config = $this->config->item('upload'); // Se almacenan los parametros de configuracion en $config
            $config['upload_path'] = $path; // Se agrega la ruta donde se va a guardar el archivo.
            
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('path') )
            {
                $error = $this->upload->display_errors();
                $data['mensaje'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$error.'</div>';
            }
            else
            {
                $archivo = array('upload_data' => $this->upload->data());

                $adjunto = array(
                    'path' => $this->upload_path,
                    'file_name' => $archivo['upload_data']['file_name'],
                    'observaciones' => $this->input->post('observaciones'),
                    'descripcion' => $this->input->post('descripcion')
                );

                $this->c->save_adjunto($adjunto, $id_contrato);
                $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Adjunto subido correctamente</div>';
            }
        }
        $this->load->view('operacion/contratos/formulario_adjuntos', $data);
    }
    
    public function contratos_adjuntos_update($id_adjunto = null, $id_contrato = null) {
        if (!empty($id_contrato) && !empty($id_adjunto)) {
            $this->load->model('contrato', 'c');
            $data['contrato'] = $this->c->get_by_id($id_contrato)->row();
            $data['adjunto'] = $this->c->get_by_id_adjunto($id_adjunto)->row();
        }
        else {
            redirect(site_url('operacion/ferias/contratos_adjuntos/') . '/' . $id_contrato);
        }

        $data['titulo'] = 'Adjuntos de Contrato <small>Modificar</small>';
        $data['link_back'] = anchor('operacion/ferias/contratos_adjuntos/' . $id_contrato,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ferias/contratos_adjuntos_update/' . $id_adjunto.'/'.$id_contrato);
	
        if ( $this->input->post() ) {
            $adjunto = array(
                'observaciones' => $this->input->post('observaciones'),
                'descripcion' => $this->input->post('descripcion')
            );

            $this->c->update_adjunto($adjunto, $id_adjunto);
            $data['adjunto'] = $this->c->get_by_id_adjunto($id_adjunto)->row();
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Adjunto actualizado correctamente</div>';
        }
        $this->load->view('operacion/contratos/formulario_adjuntos', $data);
    }
    
    public function contratos_adjuntos_delete( $id_adjunto = null, $id_contrato = null ) {
        $this->load->model('contrato', 'c');
        
        if(!empty($id_contrato) && !empty($id_adjunto)){
            $adjunto = $this->c->get_by_id_adjunto($id_adjunto)->row();
            if( !empty($adjunto) ){

                /*
                 *  FALTA ENVIAR UN MENSAJE AL USUARIO CUANDO OCURRE UN ERROR
                 */
                
                if( $this->c->delete_adjunto($id_adjunto, $id_contrato) ){
                    if( unlink( $adjunto->path.$id_contrato.'/'.$adjunto->file_name ) ){
                        redirect(site_url('operacion/ferias/contratos_adjuntos/'.$id_contrato));
                    }else{
                        die("Error al borrar el archivo");
                    }
                }else{
                    die("Error al borrar los registros de la base de datos");
                }
            }
            redirect(site_url('operacion/ferias/contratos_adjuntos/'.$id_contrato));
        }
    }

}

?>
