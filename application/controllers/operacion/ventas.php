<?php

class Ventas extends CI_Controller{
    
    public $layout = 'template_backend';
    private $upload_path;
    
    function __construct() {
        parent::__construct();
        $this->upload_path = $this->config->item('contratos_adjuntos_path');
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
        $contratos = $this->a->get_paged_list($page_limit, $offset)->result();
        $this->load->library('pagination');
        $config['base_url'] = site_url('operacion/ventas/contratos/');
        $config['total_rows'] = $this->a->count_all();
        $config['uri_segment'] = 4;
        $config['per_page'] = $page_limit;
        $this->pagination->initialize($config);

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('-');
        $tmpl = array ('table_open'  => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Estado', 'No.', 'Cliente', array('data' => 'Importe','class' => 'hidden-phone'), '','','', '');
        foreach ($contratos as $contrato) {
            /*$modulos = $this->a->get_modulos($contrato->id)->result();
            $calle = '';
            $mods = '';
            $total = 0;
            $i=0;
            foreach ($modulos as $m){
                if($m->calle != $calle){
                    if($calle != '')
                        $mods .= '<br/>';
                    $mods .= $m->calle.': ';
                    $calle = $m->calle;
                    $i=0;
                }else
                    $mods.=', ';
                $mods .= $m->modulo;
                $total += $m->importe;                
            }*/
            $modulos = $this->a->get_modulos($contrato->id);
            $num_modulos = $modulos->num_rows();
            $total = $this->a->get_importe($contrato->id);
            $this->table->add_row(
                '<i class="'.($contrato->estado == 'pendiente' ? 'icon-time' : ($contrato->estado == 'autorizado' ? 'icon-ok' : 'icon-remove')).'"></i>',
                $contrato->numero,
                $contrato->cliente,
                array('data' => number_format($total,2,'.',','), 'class' => 'hidden-phone'),
                //$mods,
                array('data' => ($contrato->estado == 'autorizado' ? anchor_popup('operacion/ventas/contratos_documento/' . $contrato->id, '<i class="icon-print"></i>', array('class' => 'btn btn-small', 'title' => 'Imprimir')) : '<a class="btn btn-small disabled"><i class="icon-print"></i></a>'), 'class' => 'hidden-phone'),
                ($contrato->estado == 'pendiente' ? anchor('operacion/ventas/contratos_modulos/' . $contrato->id, '<i class="icon-road"></i>', array('class' => 'btn btn-small', 'title' => 'Módulos')) : '<a class="btn btn-small disabled"><i class="icon-road"></i></a>'),
                ($contrato->estado == 'pendiente' ? anchor('operacion/ventas/contratos_update/' . $contrato->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small', 'title' => 'Modificar')) : '<a class="btn btn-small disabled"><i class="icon-edit"></i></a>'),
                array('data' => (($contrato->estado == 'pendiente' && $num_modulos > 0) ? anchor('operacion/ventas/contratos_autorizar/'.$contrato->id,'<i class="icon-ok"></i>', array('class' => 'btn btn-small', 'title' => 'Autorizar', 'id' => 'autorizar')) : '<a class="btn btn-small disabled"><i class="icon-ok"></i></a>'), 'class' => 'hidden-phone'),
                array('data' => ($contrato->estado == 'cancelado' ? '<a class="btn btn-small disabled"><i class="icon-remove"></i></a>' : anchor('operacion/ventas/contratos_cancelar/'.$contrato->id,'<i class="icon-ban-circle"></i>', array('class' => 'btn btn-small', 'title' => 'Cancelar', 'id' => 'cancelar'))), 'class' => 'hidden-phone')
            );
        }
        
        $data['pagination'] = $this->pagination->create_links();
        $data['table'] = $this->table->generate();
        $data['titulo'] = 'Contratos <small>Listado</small>';
        $data['add_link'] = anchor('operacion/ventas/contratos_add/','<i class="icon-plus"></i> Agregar', array('class' => 'btn'));
        
        $this->load->view('operacion/contratos/lista', $data);
    }
    
    public function contratos_add(){
        
        $data['titulo'] = 'Contratos <small>Alta</small>';
        $data['link_back'] = anchor('operacion/ventas/contratos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ventas/contratos_add');
	
        $this->load->model('periodo','p');

        $data['periodo'] = $this->session->userdata('periodo');
        
        if ( ($datos = $this->input->post()) ) {
            $this->load->model('contrato', 'co');
            
            if( ($ultimo_contrato = $this->co->get_last()->row()) )
                $datos['numero'] = $ultimo_contrato->numero + 1;
            else
                $datos['numero'] = 1;
            $datos['id_usuario'] = $this->session->userdata('userid');
            $this->co->save($datos);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Contrato registrado</div>';
        }
        $this->load->view('operacion/contratos/formulario', $data);
    }
    
    
    public function contratos_update( $id = null ){
        $this->load->model('contrato', 'co');
        
        if (empty($id)) {
            redirect(site_url('operacion/ventas/contratos/'));
        }
        
        $this->load->model('cliente','c');
        
        $data['titulo'] = 'Contratos <small>Modificar</small>';
        $data['link_back'] = anchor('operacion/ventas/contratos/','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ventas/contratos_update') . '/' . $id;
	
        $contrato = $this->co->get_by_id($id)->row();
        $data['contrato'] = $contrato;
        $data['cliente'] = $this->c->get_by_id($contrato->id_cliente)->row();
                
        if( $this->input->post() ) {
            $contrato = array(
                'id_cliente' => $this->input->post('id_cliente'),
                'fecha' => $this->input->post('fecha'),
                'fecha_vencimiento' => $this->input->post('fecha_vencimiento'),
                'testigo1' => $this->input->post('testigo1'),
                'testigo2' => $this->input->post('testigo2'),
                'observaciones' => $this->input->post('observaciones')
            );
            
            $this->co->update($id, $contrato);
            $data['contrato'] = (object)$contrato;
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        $this->load->view('operacion/contratos/formulario', $data);
    }
    
    public function contratos_autorizar( $id = null ) {
        
        if(!empty($id)){
            $this->load->model('contrato', 'c');
            $this->c->autorizar($id);
        }
        redirect(site_url('operacion/ventas/contratos/'));
    }
    
    public function contratos_cancelar( $id = null ) {
        
        if(!empty($id)){
            $this->load->model('contrato', 'c');
            $this->c->cancelar($id);
        }
        redirect(site_url('operacion/ventas/contratos/'));
    }

    /**
     * --------------------------------------------------------
     * Contratos proceso
     * --------------------------------------------------------
     */
    public function contratos_modulos($id = null, $id_calle = null, $id_modulo = null) {
        
        if (empty($id)) {
            redirect('operacion/ventas/contratos/');
        }
        
        $this->load->model('contrato', 'co');
        $this->load->model('calle', 'c');
        $this->load->model('cliente','cl');
        $data['contrato'] = $this->co->get_by_id($id)->row();
        $data['cliente'] = $this->cl->get_by_id($data['contrato']->id_cliente)->row();
        $data['calles'] = $this->c->get_all()->result();
        
        $data['titulo'] = 'Contrato <small>Módulos</small>';
        $data['link_back'] = anchor('operacion/ventas/contratos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ventas/contratos_modulos') . '/' . $id .'/'. $id_calle;
        
        if(!empty($id_calle)){
            $data['calle'] = $this->c->get_by_id($id_calle)->row();
            $this->load->model('modulo', 'm');
            $data['modulos'] = $this->m->get_disponibles($id_calle)->result();
            if(!empty($id_modulo)){
                $data['modulo'] = $this->m->get_by_id($id_modulo)->row();
            }
        }
        if ( ($datos = $this->input->post()) ) {
            $result = $this->co->save_modulo( $datos );
            if($result > 0){
                $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Módulo agregado correctamente</div>';
            }else{
                $data['mensaje'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Error al agregar el módulo</div>';
            }
            $data['modulos'] = $this->m->get_disponibles($id_calle)->result();
        }
        
        $modulos = $this->co->get_modulos($id)->result();
        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('-');
        $tmpl = array ('table_open'  => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Calle', 'Módulo', array('data' => 'Categoría','class' => 'hidden-phone'), array('data' => 'Tipo','class' => 'hidden-phone'), 'Importe', '');
        
        foreach ($modulos as $m) {
            $this->table->add_row(
                $m->calle,
                $m->modulo,
                array('data' => ucfirst($m->categoria), 'class' => 'hidden-phone'),
                array('data' => ucfirst($m->tipo), 'class' => 'hidden-phone'),
                number_format($m->importe,2,'.',','),
                array('data' => anchor('operacion/ventas/contratos_delete_modulo/' . $id.'/'.$id_calle.'/'.$m->id_modulo, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Quitar')), 'class' => 'hidden-phone')
            );
        }
        $data['table'] = $this->table->generate();

        $this->load->helper('form');
        $this->load->view('operacion/contratos/contratos_modulos', $data);

    }
    
    public function contratos_delete_modulo( $id = null, $id_calle = null, $id_modulo = null ){
        if(empty($id_modulo) or empty($id) or empty($id_calle)){
            redirect('operacion/ventas/contratos_modulos/');
        }
        $this->load->model('contrato','co');
        $this->co->delete_modulo($id_modulo);
        redirect('operacion/ventas/contratos_modulos/'.$id.'/'.$id_calle);
    }
    
    /********************
     *  Impresión de contratos
     * 
     ********************/
    public function contratos_documento( $id = null ){
        if(!empty($id)){
            $this->layout = "template_pdf";
            $this->load->model('contrato', 'a');
            if( $this->session->flashdata('pdf') ){
                $contrato = $this->a->get_by_id($id)->row();
                if($contrato){
                    $modulos = $this->a->get_modulos($contrato->id)->result_array();
                    $importe = $this->a->get_importe($contrato->id);
                    
                    $this->load->model('cliente','cl');
                    $cliente = $this->cl->get_by_id($contrato->id_cliente)->row();
                    
                    $this->load->model('giro','g');
                    $giro = $this->g->get_by_id($cliente->id_giro)->row();
                    
                    $this->load->library('tbs');
                    $this->load->library('numero_letras');
                    
                    // Nombres de meses en español (config/sitio.php)
                    $meses = $this->config->item('meses');
                    
                    // Se carga el template predefinido para los recibos (tabla Configuracion)
                    $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_contratos'));
                    
                    // Se sustituyen los campos en el template
                    $this->tbs->VarRef['numero_contrato'] = $contrato->numero;
                    $this->tbs->VarRef['cliente'] = $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno;
                    $this->tbs->VarRef['testigo1'] = $contrato->testigo1;
                    $this->tbs->VarRef['testigo2'] = $contrato->testigo2;
                    $this->tbs->VarRef['giro'] = $giro->nombre;
                    $this->tbs->VarRef['calle'] = $cliente->calle;
                    $this->tbs->VarRef['numero'] = $cliente->numero_exterior.$cliente->numero_interior;
                    $this->tbs->VarRef['colonia'] = $cliente->colonia;
                    $this->tbs->VarRef['ciudad'] = $cliente->ciudad;
                    $this->tbs->VarRef['estado'] = $cliente->estado;
                    $this->tbs->VarRef['importe'] = '$'.number_format($importe,2,'.',',');
                    $this->tbs->VarRef['importe_letra'] = $this->numero_letras->convertir($importe);
                    
                    $fecha_inicio = date_create($contrato->fecha_inicio);
                    $this->tbs->VarRef['fecha_inicio'] = date_format($fecha_inicio,'d/m/Y');
                    $this->tbs->VarRef['dia_inicio'] = date_format($fecha_inicio,'d');
                    $this->tbs->VarRef['mes_inicio'] = $meses[date_format($fecha_inicio,'n')-1];
                    $this->tbs->VarRef['ano_inicio'] = date_format($fecha_inicio,'Y');
                    
                    $fecha_vencimiento = date_create($contrato->fecha_vencimiento);
                    $this->tbs->VarRef['fecha_vencimiento'] = date_format($fecha_vencimiento,'d/m/Y');
                    $this->tbs->VarRef['dia_vencimiento'] = date_format($fecha_vencimiento,'d');
                    $this->tbs->VarRef['mes_vencimiento'] = $meses[date_format($fecha_vencimiento,'n')-1];
                    $this->tbs->VarRef['ano_vencimiento'] = date_format($fecha_vencimiento,'Y');
                    
                    $fecha = date_create($contrato->fecha);
                    $this->tbs->VarRef['fecha'] = date_format($fecha,'d/m/Y');
                    $this->tbs->VarRef['dia'] = date_format($fecha,'d');
                    $this->tbs->VarRef['mes'] = $meses[date_format($fecha,'n')-1];
                    $this->tbs->VarRef['ano'] = date_format($fecha,'Y');
                    // Render sin desplegar en navegador
                    foreach($modulos as $key => $value){
                        $modulos[$key]['importe'] = '$'.number_format($modulos[$key]['importe'],2,'.',',');
                    }
                    $this->tbs->MergeBlock('modulos', $modulos);
                    $this->tbs->Show(TBS_NOTHING);
                    // Se almacena el render en el array $data
                    $data['contenido'] = $this->tbs->Source;
                    
                    $this->load->view('documento', $data);
                }else{
                    redirect('operacion/ventas/contratos');
                }
            }else{
                $this->session->set_flashdata('pdf', true);
                redirect('operacion/ventas/contratos_documento/'.$id); // Se recarga el método para imprimirlo como PDF
            }
        }else{
            redirect('operacion/ventas/contratos');
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
            $config['base_url'] = site_url('operacion/ventas/contratos_adjunto/' . $id_contrato);
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
                    array('data' => anchor('operacion/ventas/contratos_adjuntos_update/' . $adjunto->id_adjunto . '/' . $adjunto->id_contrato, '<i class="icon-edit"></i>', array('class' => 'btn btn-small', 'title' => 'Modificar')), 'class' => 'hidden-phone'),
                    array('data' => anchor('operacion/ventas/contratos_adjuntos_delete/' . $adjunto->id_adjunto . '/' . $adjunto->id_contrato, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Borrar')), 'class' => 'hidden-phone')
                );
            }

            $data['table'] = $this->table->generate();
            $data['link_add'] = anchor('operacion/ventas/contratos_adjuntos_add/' . $id_contrato,'<i class="icon-plus"></i> Agregar adjunto', array('class' => 'btn'));
        }
        
        $data['link_back'] = anchor('operacion/ventas/contratos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['titulo'] = 'Contrato <small>Adjuntos</small>';
        $this->load->view('operacion/contratos/lista_adjuntos', $data);
    }
    
    public function contratos_adjuntos_add($id_contrato = null) {
        if (!empty($id_contrato)) {
            $this->load->model('contrato', 'c');
            $data['contrato'] = (object)$this->c->get_by_id($id_contrato)->row();
        }
        else {
            redirect(site_url('operacion/ventas/contratos_adjuntos/') . '/' . $id_contrato);
        }

        $data['titulo'] = 'Adjuntos de Contrato <small>Agregar</small>';
        $data['link_back'] = anchor('operacion/ventas/contratos_adjuntos/' . $id_contrato,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ventas/contratos_adjuntos_add/' . $id_contrato);
	
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
            redirect(site_url('operacion/ventas/contratos_adjuntos/') . '/' . $id_contrato);
        }

        $data['titulo'] = 'Adjuntos de Contrato <small>Modificar</small>';
        $data['link_back'] = anchor('operacion/ventas/contratos_adjuntos/' . $id_contrato,'<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ventas/contratos_adjuntos_update/' . $id_adjunto.'/'.$id_contrato);
	
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
                        redirect(site_url('operacion/ventas/contratos_adjuntos/'.$id_contrato));
                    }else{
                        die("Error al borrar el archivo");
                    }
                }else{
                    die("Error al borrar los registros de la base de datos");
                }
            }
            redirect(site_url('operacion/ventas/contratos_adjuntos/'.$id_contrato));
        }
    }

}

?>