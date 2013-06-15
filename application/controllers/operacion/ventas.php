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
        $resultado = $this->a->get_paged_list($page_limit, $offset);
        if($resultado)
            $contratos = $resultado->result();
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
        if(isset($contratos)){
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
                    array('data' => (anchor_popup('operacion/ventas/contratos_documento/' . $contrato->id, '<i class="icon-print"></i>', array('class' => 'btn btn-small', 'title' => 'Imprimir'))), 'class' => 'hidden-phone'),
                    ($contrato->estado == 'pendiente' ? anchor('operacion/ventas/contratos_modulos/' . $contrato->id, '<i class="icon-road"></i>', array('class' => 'btn btn-small', 'title' => 'Módulos')) : '<a class="btn btn-small disabled"><i class="icon-road"></i></a>'),
                    ($contrato->estado == 'pendiente' ? anchor('operacion/ventas/contratos_update/' . $contrato->id, '<i class="icon-edit"></i>', array('class' => 'btn btn-small', 'title' => 'Modificar')) : '<a class="btn btn-small disabled"><i class="icon-edit"></i></a>'),
                    array('data' => (($contrato->estado == 'pendiente' && $num_modulos > 0) ? anchor('operacion/ventas/contratos_autorizar/'.$contrato->id,'<i class="icon-ok"></i>', array('class' => 'btn btn-small', 'title' => 'Autorizar', 'id' => 'autorizar')) : '<a class="btn btn-small disabled"><i class="icon-ok"></i></a>'), 'class' => 'hidden-phone'),
                    array('data' => ($contrato->estado == 'cancelado' ? '<a class="btn btn-small disabled"><i class="icon-remove"></i></a>' : anchor('operacion/ventas/contratos_cancelar/'.$contrato->id,'<i class="icon-ban-circle"></i>', array('class' => 'btn btn-small', 'title' => 'Cancelar', 'id' => 'cancelar'))), 'class' => 'hidden-phone')
                );
            }
            $data['add_link'] = anchor('operacion/ventas/contratos_add/','<i class="icon-plus"></i> Agregar', array('class' => 'btn'));
        }else{
            $data['add_link'] = '<div class="alert"><strong>Aviso:</strong> Para agregar un contrato es necesario un período activo</div>';
        }
        $data['table'] = $this->table->generate();
        $data['pagination'] = $this->pagination->create_links();
        $data['titulo'] = 'Contratos <small>Listado</small>';
        
        $this->load->view('operacion/contratos/lista', $data);
    }
    
    private function contratos_render_template($id){
        $this->load->model('contrato', 'c');
            
        $contrato = $this->c->get_by_id($id)->row();
        //$modulos = $this->c->get_modulos($contrato->id)->result_array();
        $modulos = $this->c->get_modulos_agrupados($contrato->id)->result_array();
        $importe = $this->c->get_importe($contrato->id);

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
        $this->tbs->VarRef['numero_contrato'] = $contrato->numero.'/'.$contrato->sufijo;
        if($cliente->tipo == 'moral'){
            $this->tbs->VarRef['razon_social'] = $cliente->razon_social;
            $this->tbs->VarRef['mensaje_representante'] = ' representada en este acto por el(la) C. ';
            $this->tbs->VarRef['cliente'] = $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno;
        }else{
            $this->tbs->VarRef['cliente'] = $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno;
            $this->tbs->VarRef['mensaje_representante'] = ' el(la) C. ';
            $this->tbs->VarRef['razon_social'] = '';
        }
        //$this->tbs->VarRef['cliente'] = $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno;
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
        
        foreach($modulos as $key => $value){
            $modulos[$key]['importe'] = '$'.number_format($modulos[$key]['importe'],2,'.',',');
            $modulos[$key]['total'] = '$'.number_format($modulos[$key]['total'],2,'.',',');
            $modulos[$key]['categoria'] = ucfirst($modulos[$key]['categoria']);
        }
        $this->tbs->MergeBlock('modulos', $modulos);
        // Render sin desplegar en navegador
        $this->tbs->Show(TBS_NOTHING);
        // Se regresa el render
        return $this->tbs->Source;
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
            $datos['sufijo'] = $data['periodo']->sufijo_contratos;
            $datos['id_usuario'] = $this->session->userdata('userid');
            $datos['id_periodo'] = $data['periodo']->id;  // Período activo de la feria
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
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        
        $contrato = $this->co->get_by_id($id)->row();
        $data['contrato'] = $contrato;
        $data['cliente'] = $this->c->get_by_id($contrato->id_cliente)->row();
        
        $this->load->view('operacion/contratos/formulario', $data);
    }
    
    public function contratos_autorizar( $id = null ) {
        
        if(!empty($id)){
            $this->load->model('contrato', 'c');
            
            $contrato = $this->c->get_by_id($id)->row();
            // Se genera el documento para impresión y se guarda en la base de datos
            // en formato HTML
            if($contrato){
                // Se almacena el render en el array $data
                $documento = $this->contratos_render_template($id);
                
                $this->c->autorizar($id, $documento);
            }
        }
        redirect('operacion/ventas/contratos/');
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
        $this->load->model('modulo', 'm');
        
        $this->load->library('rango'); // Para los rangos de módulos
        
        $data['contrato'] = $this->co->get_by_id($id)->row();
        $data['cliente'] = $this->cl->get_by_id($data['contrato']->id_cliente)->row();
        $data['calles'] = $this->c->get_all()->result();
        
        $data['titulo'] = 'Contrato <small>Módulos</small>';
        $data['link_back'] = anchor('operacion/ventas/contratos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/ventas/contratos_modulos') . '/' . $id .'/'. $id_calle;
        
        if ( ($datos = $this->input->post()) ) {
            //$datos['iva'] = $datos['subtotal'] * $this->configuracion->get_valor('iva');
            //$datos['importe'] = $datos['subtotal'] + $datos['iva'];
            
            $modulos_array = $this->rango->rango_to_array($datos['modulos']);
            unset($datos['modulos']);
            foreach($modulos_array as $item){
                $modulo = $this->m->get_by_calle_numero($id_calle, $item);
                if($modulo){
                    if( $this->m->disponible($modulo->id) ){
                        $datos['subtotal'] = $modulo->precio;
                        $datos['iva'] = $modulo->precio * $this->configuracion->get_valor('iva');
                        $datos['importe'] = $modulo->precio + $datos['iva'];
                        $datos['id_modulo'] = $modulo->id;

                        $result = $this->co->save_modulo( $datos );
                        if($result > 0){
                            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Módulo(s) agregado(s) correctamente</div>';
                        }else{
                            $data['mensaje'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Error al agregar el(los) módulo(s)</div>';
                        }
                    }
                }
            }
            //$data['modulos'] = $this->m->get_disponibles($id_calle)->result();
        }
        
        if(!empty($id_calle)){
            $data['calle'] = $this->c->get_by_id($id_calle)->row();
            //$data['modulos'] = $this->m->get_disponibles($id_calle)->result();
            
            // Para indicarle al usuarios los módulos disponibles
            $modulos_disponibles = $this->m->get_disponibles($id_calle)->result();
            $output = array();
            foreach($modulos_disponibles as $modulo){
                $output[] = $modulo->numero;
            }
            $data['modulos'] = $this->rango->array_to_rango($output); // Devuelve una cadena tipo: 1-4, 7, 9-11
            
            if(!empty($id_modulo)){
                $data['modulo'] = $this->m->get_by_id($id_modulo)->row();
                //$data['importe'] = $data['modulo']->precio * (1 + $this->configuracion->get_valor('iva'));
            }
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
                array('data' => anchor('operacion/ventas/contratos_delete_modulo/' . $id.'/'.$m->id_calle.'/'.$m->id_modulo, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Quitar')), 'class' => 'hidden-phone')
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
            $contrato = $this->a->get_by_id($id)->row();
            if( $this->session->flashdata('pdf') ){
                if($contrato){
                    if($contrato->estado == 'autorizado'){
                        $data['contenido'] = $contrato->documento;
                    }else{
                        $data['contenido'] = $this->contratos_render_template($id);
                    }
                    $this->load->view('documento', $data);
                }else{
                    redirect('operacion/ventas/contratos');
                }
            }else{
                $this->session->set_flashdata('pdf', true);
                if($contrato){
                    if($contrato->estado == 'cancelado'){  // Se agrega una marca de agua al PDF
                        $this->session->set_flashdata('watermark', 'Cancelado');
                    }elseif($contrato->estado == 'pendiente'){
                        $this->session->set_flashdata('watermark', 'Para autorización');
                    }
                }
                redirect('operacion/ventas/contratos_documento/'.$id); // Se recarga el método para imprimirlo como PDF
            }
        }else{
            redirect('operacion/ventas/contratos');
        }
    }
    
    public function contratos_adeudo(){
        if($this->input->is_ajax_request()){
            if(($query = $this->input->post('q', true))){
                $this->load->model('contrato','c');
                if(( $contratos = $this->c->get_con_adeudo($query) )){
                    //unset($contratos->documento);
                    echo json_encode($contratos->result());
                }else
                    echo json_encode(false);
            }
            else {
                echo json_encode(false);
            }
        }
    }
    
    /*
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

                //
                //  FALTA ENVIAR UN MENSAJE AL USUARIO CUANDO OCURRE UN ERROR
                //
                
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
    */

    /**
     * ----------------------------------------------------
     * Métodos para recibos
     * ----------------------------------------------------
     */
    
    public function recibos( $offset = 0 ){
        $this->load->model('recibo','a');
        $this->load->model('contrato','c');
        
        $offset = floatval($offset);
        
        // generar paginacion
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        $resultado = $this->a->get_paged_list($page_limit, $offset);
        if($resultado)
            $recibos = $resultado->result();
        $this->load->library('pagination');
        $config['base_url'] = site_url('operacion/ventas/recibos/');
        $config['total_rows'] = $this->a->count_all();
        $config['uri_segment'] = 4;
        $config['per_page'] = $page_limit;
        $this->pagination->initialize($config);

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('-');
        $tmpl = array ('table_open'  => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Estado', 'Fecha', 'No.', 'Contrato', array('data' => 'Factura', 'class' => 'hidden-phone'), array('data' => 'Cliente', 'class' => 'hidden-phone'), 'Importe', '','','', '');
        if(isset($recibos)){
            foreach ($recibos as $recibo) {
                $contrato = $this->c->get_by_id($recibo->id_contrato)->row();
                $clase = '';
                $fecha = date_create($recibo->fecha);
                if($recibo->estado == 'cancelado')
                    $clase = 'muted';
                $this->table->add_row(
                    '<i class="'.($recibo->estado == 'vigente' ? 'icon-ok' : 'icon-remove').'"></i>',
                    date_format($fecha,'Y-m-d'),
                    $recibo->numero,
                    $contrato->numero.'/'.$contrato->sufijo,
                    array('data' => $recibo->serie.' '.$recibo->folio, 'class' => 'hidden-phone'),
                    array('data' => $recibo->cliente, 'class' => 'hidden-phone'),
                    number_format($recibo->total,2,'.',','),
                    array('data' => ($recibo->estado == 'cancelado' ? '<a class="btn btn-small disabled"><i class="icon-print"></i></a>' : anchor_popup('operacion/ventas/recibos_documento/' . $recibo->id, '<i class="icon-print"></i>', array('class' => 'btn btn-small', 'title' => 'Imprimir'))), 'class' => 'hidden-phone'),
                    array('data' => (($recibo->estado == 'cancelado' || (!empty($recibo->id_factura) && $recibo->estatus_factura == 1)) ? '<a class="btn btn-small disabled"><i class="icon-qrcode"></i></a>' : anchor('operacion/administracion/facturas_add/' . $recibo->id, '<i class="icon-qrcode"></i>', array('class' => 'btn btn-small', 'title' => 'Facturar'))), 'class' => 'hidden-phone'),
                    array('data' => (($recibo->estado == 'cancelado' || $recibo->estatus_factura == 1) ? '<a class="btn btn-small disabled"><i class="icon-ban-circle"></i></a>' : anchor('operacion/ventas/recibos_cancelar/'.$recibo->id,'<i class="icon-ban-circle"></i>', array('class' => 'btn btn-small', 'title' => 'Cancelar', 'id' => 'cancelar'))), 'class' => 'hidden-phone')
                );
                $this->table->add_row_class($clase);
            }
            $data['add_link'] = anchor('operacion/ventas/recibos_add/','<i class="icon-plus"></i> Agregar', array('class' => 'btn'));
        }else{
            $data['add_link'] = '<div class="alert"><strong>Aviso:</strong> No hay período activo.</div>';
        }
        
        $data['pagination'] = $this->pagination->create_links();
        $data['table'] = $this->table->generate();
        $data['titulo'] = 'Recibos <small>Listado</small>';
        
        $this->load->view('operacion/recibos/lista', $data);
    }
    
    public function recibos_add( $id_contrato = null ){
        
        $data['titulo'] = 'Recibos <small>Nuevo</small>';
        $data['link_back'] = anchor('operacion/ventas/recibos','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        if(!empty($id_contrato)){
            $data['action'] = site_url('operacion/ventas/recibos_add/'.$id_contrato);
        }else{
            $data['action'] = site_url('operacion/ventas/recibos_add');
        }
	
        $this->load->model('periodo','p');
        $data['periodo'] = $this->session->userdata('periodo');
        
        $this->load->model('cliente','cl');
        
        if ( ($datos = $this->input->post()) ) {
            $this->load->model('recibo', 'r');
            
            if( ($ultimo_recibo = $this->r->get_last()->row()) )
                $datos['numero'] = $ultimo_recibo->numero + 1;
            else
                $datos['numero'] = 1;
            $datos['id_usuario'] = $this->session->userdata('userid');
            
            $tasa_iva = $this->configuracion->get_valor('iva');
            $datos['subtotal'] = $datos['total'] / (1+$tasa_iva);
            $datos['iva'] = $datos['total'] - $datos['subtotal'];
            
            // Datos del contrato
            $this->load->model('contrato','c');
            $contrato = $this->c->get_by_id($datos['id_contrato'])->row();
            
            // Datos del cliente
            $cliente = $this->cl->get_by_id($contrato->id_cliente)->row();
            
            // Documento
            $this->load->library('tbs');
            $this->load->library('numero_letras');

            // Nombres de meses en español (config/sitio.php)
            $meses = $this->config->item('meses');

            // Se carga el template predefinido para los recibos (tabla Configuracion)
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_recibos'));

            // Se sustituyen los campos en el template
            $logo = $this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('imagenes').$this->configuracion->get_valor('logo');
            $this->tbs->VarRef['logo'] = base_url($logo);
            $this->tbs->VarRef['folio'] = $datos['numero'];
            if($cliente->tipo == 'moral'){
                $this->tbs->VarRef['cliente'] = $cliente->razon_social;
            }else{
                $this->tbs->VarRef['cliente'] = $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno;
            }
            $this->tbs->VarRef['calle'] = $cliente->calle;
            $this->tbs->VarRef['numero'] = $cliente->numero_exterior.$cliente->numero_interior;
            $this->tbs->VarRef['colonia'] = $cliente->colonia;
            $this->tbs->VarRef['ciudad'] = $cliente->ciudad;
            $this->tbs->VarRef['estado'] = $cliente->estado;
            if($datos['tipo'] == 'anticipo')
                $concepto = "Anticipo";
            elseif($datos['tipo'] == 'total')
                $concepto = "Pago total";
            $concepto.=" al contrato No. ".$contrato->numero."/".$contrato->sufijo." por renta de espacio para la Feria de Todos los Santos Colima ".$contrato->sufijo;
            $this->tbs->VarRef['concepto'] = $concepto;
            
            $this->load->model('giro','g');
            $giro = $this->g->get_by_id($cliente->id_giro)->row();
            $this->tbs->VarRef['giro'] = $giro->nombre;
            
            $this->load->model('concesion','cs');
            $concesion = $this->cs->get_by_id($cliente->id_concesion)->row();
            $this->tbs->VarRef['concesion'] = $concesion->nombre;
            
            $this->tbs->VarRef['importe'] = '$'.number_format($datos['total'],2,'.',',');
            $this->tbs->VarRef['importe_letra'] = $this->numero_letras->convertir(number_format($datos['total'],2,'.',''));

            $fecha = date_create();
            $this->tbs->VarRef['fecha'] = date_format($fecha,'d/m/Y');
            $this->tbs->VarRef['dia'] = date_format($fecha,'d');
            $this->tbs->VarRef['mes'] = $meses[date_format($fecha,'n')-1];
            $this->tbs->VarRef['ano'] = date_format($fecha,'Y');
            // Render sin desplegar en navegador
            $this->tbs->Show(TBS_NOTHING);
            // Se almacena el render en el array $data
            $datos['documento'] = $this->tbs->Source;
            
            $this->r->save($datos);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Recibo registrado</div>';
        }
        
        $this->load->model('contrato','c');
        $data['contratos'] = $this->c->get_con_adeudo()->result();
        if(!empty($id_contrato)){
            $data['id_contrato'] = $id_contrato;
            $data['contrato'] = $this->c->get_by_id($id_contrato)->row();
            $data['cliente'] = $this->cl->get_by_id($data['contrato']->id_cliente)->row();
            $data['total'] = $this->c->get_importe( $id_contrato );
            $data['abonos'] = $this->c->get_abonos( $id_contrato );
            $data['notas'] = $this->c->get_notas( $id_contrato );
            $data['saldo'] = $this->c->get_saldo( $id_contrato );
        }
        $this->load->view('operacion/recibos/formulario', $data);
    }
    
    public function recibos_cancelar( $id = null ) {
        
        if(!empty($id)){
            $this->load->model('recibo', 'r');
            $this->r->cancelar($id);
        }
        redirect(site_url('operacion/ventas/recibos/'));
    }
    
    /********************
     *  Impresión de recibos
     * 
     ********************/
    public function recibos_documento( $id = null ){
        if(!empty($id)){
            $this->layout = "template_pdf";
            $this->load->model('recibo', 'r');
            $recibo = $this->r->get_by_id($id)->row();
            if( $this->session->flashdata('pdf') ){
                if($recibo){
                    $data['contenido'] = $recibo->documento;
                    $this->load->view('documento', $data);
                }else{
                    redirect('operacion/ventas/recibos');
                }
            }else{
                $this->session->set_flashdata('pdf', true);
                if($recibo){
                    if($recibo->estado == 'cancelado')  // Se agrega una marca de agua al PDF
                        $this->session->set_flashdata('watermark', 'Cancelado');
                }
                redirect('operacion/ventas/recibos_documento/'.$id); // Se recarga el método para imprimirlo como PDF
            }
        }else{
            redirect('operacion/ventas/recibos');
        }
    }
    
    // Muestra el plano de la feria
    public function plano(){
        $data['plano'] = base_url().$this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('imagenes').$this->configuracion->get_valor('plano');
            
        // Se obtienen todos los módulos
        $this->load->model('modulo','m');
        $modulos = $this->m->get_all()->result();
        $coordenadas = '';
        foreach($modulos as $modulo){
            // Si el módulo tiene coordenadas asignadas
            if(!empty($modulo->coordenadas))
                if(strpos($modulo->coordenadas,'x') && strpos($modulo->coordenadas,'y')) // Se valida que el campo coordenadas contenga los caracteres 'x' y 'y'
                    $coordenadas .= '{'.$modulo->coordenadas.',numero: "'.$modulo->numero.'",id_calle: "'.$modulo->id_calle.'", calle: "'.$modulo->calle.'", id: "'.$modulo->id.'", cliente: "'. $modulo->cliente .'", giro: "'. $modulo->giro .'", disponible: "'.$modulo->disponible.'"},';
        }
        $data['coordenadas'] = '['.substr_replace($coordenadas ,"]",-1);
        $this->load->view('operacion/plano', $data);
    }
    
}

?>
